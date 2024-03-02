<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    try {
        $stmt = $conexion->prepare("UPDATE Usuarios SET nombre = ?, apellido = ?, email = ? WHERE id = ?");
        $stmt->execute([$nombre, $apellido, $email, $id]);
        header('Location: usuarios_listado.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT nombre, apellido, email FROM Usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Editar Usuario</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
            <br>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" value="<?php echo $usuario['apellido']; ?>" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
    </center>
</body>

</html>
