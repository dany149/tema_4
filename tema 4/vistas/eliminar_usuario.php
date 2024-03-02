<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        $stmt = $conexion->prepare("DELETE FROM Usuarios WHERE id = ?");
        $stmt->execute([$id]);
        header('Location: usuarios_listado.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    $id = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eliminar Usuario</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Eliminar Usuario</h2>
        <p>¿Está seguro de eliminar este usuario?</p>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit">Confirmar Eliminación</button>
        </form>
    </center>
</body>

</html>
