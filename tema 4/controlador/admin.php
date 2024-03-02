<?php
session_start();

include '../modelo/modelo.php';

// Protección de acceso
if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: ../vistas/login.php');
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Página de Administrador</title>
    <link rel="stylesheet" type="text/css" href="../css/css2.css">
</head>

<body>
    <center>
        <h2>Bienvenido Administrador</h2>
        <ul>
            <li><a href="usuarios.php">Gestionar Usuarios</a></li>
            <li><a href="entradas.php">Gestionar Entradas</a></li>
            <li><a href="categorias.php">Gestionar Categorías</a></li>
            <br><br>
            <li><a href="../vistas/entradas_listado.php">Lista Entradas</a></li>
            <li><a href="../vistas/usuarios_listado.php">Lista Usuarios</a></li>
            <li><a href="../vistas/categorias_listado.php">Lista categoria</a></li>
            <br><br>
            <li><a href="../vistas/dinamica.php.">Dinamica Usuario y Entradas</a></li>
            <br><br>
            <li><a href="../vistas/paginacion.php.">Paginación</a></li>
            <br><br>
            <li><a href="CKEditor.php.">CKEditor</a></li>
            <br><br>
            <li><a href="../vistas/entradas_pdf.php.">pdf</a></li>
            <br><br>
            <li><a href="../vistas/orden.php.">orden</a></li>
            <br><br>
            <li><a href="../vistas/log.php.">log</a></li>
            
        </ul>
        <br>
        <a href="../controlador/logout.php">Cerrar Sesión</a>
    </center>
</body>

</html>