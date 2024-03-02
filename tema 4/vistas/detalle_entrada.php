<?php
session_start();

include '../modelo/conexion.php';

// Verificar sesión activa
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener detalles de la entrada
$id = $_GET['id'];
$stmt = $conexion->prepare("SELECT titulo, contenido, fecha_creacion FROM Entradas WHERE id = ?");
$stmt->execute([$id]);
$entrada = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Detalle de Entrada</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Detalle de Entrada</h2>
        <h3><?php echo $entrada['titulo']; ?></h3>
        <p><?php echo $entrada['contenido']; ?></p>
        <p>Fecha de Creación: <?php echo $entrada['fecha_creacion']; ?></p>
    </center>
</body>

</html>
