<?php
session_start();

include '../modelo/modelo.php'; 

// Verificar si hay una sesión activa
if (isset($_SESSION['usuario_id'])) {
    if ($_SESSION['perfil_usuario'] == 'admin') {
        header('Location: admin.php');
    } elseif ($_SESSION['perfil_usuario'] == 'user') {
        header('Location: user.php');
    }
    exit();
}


$conexion = conectarBD();

// Verificar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    try {
        $stmt = $conexion->prepare("SELECT id, perfil, password FROM usuarios WHERE nombre = :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($contrasena, $resultado['password'])) {
            $_SESSION['usuario_id'] = $resultado['id'];
            $_SESSION['perfil_usuario'] = $resultado['perfil'];

            // Cookies para recordar la sesión
            if (isset($_POST['recordar'])) {
                $expira = time() + 3600 * 24 * 30; 
                setcookie('usuario_recuerda', $usuario, $expira, '/');
                setcookie('contrasena_recuerda', $contrasena, $expira, '/');
            }

            header('Location: ../vistas/inicio.php');
            exit();
        } else {
            $mensaje_error = "Inicio de sesión fallido.";
        }
    } catch (PDOException $e) {
        $mensaje_error = "Error de conexión: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../css/css.css">
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($mensaje_error)) : ?>
            <p><?php echo $mensaje_error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>
            <br>
            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>
            <br>
            <input type="checkbox" name="recordar"> Recordar sesión
            <br><br><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
</body>
</html>
