<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['perfil_usuario'] !== 'admin' && $_SESSION['perfil_usuario'] !== 'user')) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $categoria_id = $_POST['categoria_id'];

    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_temp = $_FILES['imagen']['tmp_name'];
    $imagen_ruta = "../images/" . $imagen_nombre;

    move_uploaded_file($imagen_temp, $imagen_ruta);

    try {
        $stmt = $conexion->prepare("INSERT INTO Entradas (titulo, contenido, categoria_id, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $contenido, $categoria_id, $imagen_ruta]);
        header('Location: entradas.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $stmt = $conexion->query("SELECT * FROM Categorias");
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Entradas</title>
    <link rel="stylesheet" type="text/css" href="../css/css3.css">
    <!-- Carga CKEditor desde un CDN -->
    <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
</head>

<body>
    <center>
        <h2>Registro de Entradas</h2>
        <form method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>
            <br>
            <label for="contenido">Contenido:</label>
            <textarea name="contenido" id="contenido" required></textarea>
            <br>
            <label for="categoria_id">Categoría:</label>
            <select name="categoria_id" required>
                <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" required>
            <br><br>
            <button type="submit">Registrar Entrada</button>
        </form>
    </center>
    <script>
        CKEDITOR.replace('contenido');
    </script>
</body>

</html>

