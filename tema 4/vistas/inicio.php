<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../controlador/login.php');
    exit();
}
if ($_SESSION['perfil_usuario'] === 'admin') {
    header('Location: ../controlador/admin.php');
    exit();
} elseif ($_SESSION['perfil_usuario'] === 'user') {
    header('Location: ../controlador/user.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    <link rel="stylesheet" type="text/css" href="../css/css2.css">
</head>

<body>
    <center>
        <h2>Bienvenido a la Página de Inicio</h2>
        <br>
        <p>Usuario: <?php echo $_SESSION['usuario_id']; ?></p>
        
        <br>
        <a href="../controlador/logout.php">Cerrar Sesión</a>
    </center>
</body>

</html>
