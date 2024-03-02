<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: usuarios_listado.php');
    exit();
}

$id_usuario = $_GET['id'];

try {
    $stmt = $conexion->prepare("SELECT * FROM Usuarios WHERE id = ?");
    $stmt->execute([$id_usuario]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Usuario</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <div class="container">
        <h2>Detalle de Usuario</h2>
        <table>
            <tr>
                <th>ID</th>
                <td><?php echo $usuario['id']; ?></td>
            </tr>
            <tr>
                <th>Nombre</th>
                <td><?php echo $usuario['nombre']; ?></td>
            </tr>
            <tr>
                <th>Apellido</th>
                <td><?php echo $usuario['apellido']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $usuario['email']; ?></td>
            </tr>
            <tr>
                <th>Perfil</th>
                <td><?php echo $usuario['perfil']; ?></td>
            </tr>
        </table>
        <a href="usuarios_listado.php">Volver al listado de usuarios</a>
    </div>
</body>

</html>
