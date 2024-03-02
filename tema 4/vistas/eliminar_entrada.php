<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        header('Location: entradas.php');
        exit();
    }

    $id_entrada = $_POST['id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM Entradas WHERE id = :id");
        $stmt->bindParam(':id', $id_entrada, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: entradas_listado.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    if (!isset($_GET['id'])) {
        header('Location: entradas_listado.php');
        exit();
    }

    $id_entrada = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar Entrada</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Eliminar Entrada</h2>
        <p>¿Estás seguro de que deseas eliminar esta entrada?</p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id_entrada; ?>">
            <button type="submit">Sí, Eliminar</button>
            <a href="entradas_listado.php">Cancelar</a>
        </form>
    </center>
</body>

</html>
