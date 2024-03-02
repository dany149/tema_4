<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_entrada = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    
  
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_ruta = "../images/" . $imagen_nombre;

  
    move_uploaded_file($imagen_temp, $imagen_ruta);

    try {
        $stmt = $conexion->prepare("UPDATE Entradas SET titulo = :titulo, contenido = :contenido, imagen = :imagen WHERE id = :id");
        $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
        $stmt->bindParam(':contenido', $contenido, PDO::PARAM_STR);
        $stmt->bindParam(':imagen', $imagen_ruta, PDO::PARAM_STR);
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

    try {
        $stmt = $conexion->prepare("SELECT * FROM Entradas WHERE id = :id");
        $stmt->bindParam(':id', $id_entrada, PDO::PARAM_INT);
        $stmt->execute();
        $entrada = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Entrada</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
</head>

<body>
    <center>
        <h2>Editar Entrada</h2>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id_entrada; ?>">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" value="<?php echo $entrada['titulo']; ?>" required>
            <br>
            <label for="contenido">Contenido:</label>
            <textarea name="contenido" rows="4" cols="50" required><?php echo $entrada['contenido']; ?></textarea>
            <br>
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen">
            <br><br>
            <button type="submit">Guardar Cambios</button>
        </form>
    </center>
</body>

</html>
