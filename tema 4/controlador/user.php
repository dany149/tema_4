<?php
session_start();

include '../modelo/modelo.php';

// Protección de acceso
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'user') {
    header('Location: ../vistas/login.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página de Usuario</title>
    <link rel="stylesheet" type="text/css" href="../css/css2.css">
</head>

<body>
    <center>
        <h2>Bienvenido Usuario</h2>
        <ul>
            <li><a href="entradas.php">Gestionar Entradas</a></li>
            <li><a href="categorias.php">Gestionar Categorías</a></li>
        </ul>

        <a href="../controlador/logout.php">Cerrar Sesión</a>
    </center>
</body>

</html>