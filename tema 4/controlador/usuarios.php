<?php
session_start();


include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $perfil = $_POST['perfil'];

    // Procesar la imagen
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_ruta = "../images/" . $imagen_nombre;

    // Mover la imagen al directorio de imágenes
    move_uploaded_file($imagen_temp, $imagen_ruta);
    var_dump(file_exists($imagen_ruta));


    // Verificar el valor de $_FILES['imagen']['error']
    if ($_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
        die('Error al subir la imagen: ' . $_FILES['imagen']['error']);
    }

    // Verificar el tamaño del archivo
    if ($_FILES['imagen']['size'] > (2 * 1024 * 1024)) { 
        die('El tamaño de la imagen es demasiado grande');
    }
    echo 'Ruta de la imagen: ' . $imagen_ruta;

    try {
        $stmt = $conexion->prepare("INSERT INTO Usuarios (nombre, apellido, email, password, perfil, imagen) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $email, $password, $perfil, $imagen_ruta]);
        header('Location: usuarios.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Registro de Usuario</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <br>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" required>
            <br>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <br>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>
            <br>
            <label for="perfil">Perfil:</label>
            <select name="perfil" required>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <br>
            <label for="imagen">Imagen de perfil:</label>
            <input type="file" name="imagen" accept="image/*">
            <br><br>
            <button type="submit">Registrar Usuario</button>
        </form>
    </center>
</body>

</html>