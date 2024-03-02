<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];

    try {
        $stmt = $conexion->prepare("INSERT INTO Categorias (nombre) VALUES (?)");
        $stmt->execute([$nombre]);
        header('Location: index.php');
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
    <title>Registro de Categorías</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>
<body>
    <center>
    <h2>Registro de Categoría</h2>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>
        <button type="submit">Registrar Categoría</button>
    </form>
    </center>
</body>
</html>
