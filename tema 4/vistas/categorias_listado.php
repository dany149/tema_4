<?php
session_start();

include '../modelo/conexion.php';

// Verificar sesión activa y perfil de usuario
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Consulta para obtener la lista de categorías
$stmt = $conexion->query("SELECT id, nombre FROM Categorias");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Categorías</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Listado de Categorías</h2>
        <ul>
            <?php foreach ($categorias as $categoria) : ?>
                <li>
                    <?php echo $categoria['nombre']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </center>
</body>

</html>
