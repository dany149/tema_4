<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Consulta ordenadas por fecha de creación
$stmt = $conexion->query("SELECT id, titulo, contenido, fecha_creacion, imagen FROM Entradas ORDER BY fecha_creacion DESC");
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Entradas</title>
    <link rel="stylesheet" type="text/css" href="../css/css4.css">
</head>

<body>
    <center>
        <h2>Listado de Entradas</h2>
        <table>
            <tr>
                <th>Título</th>
                <th>Contenido</th>
                <th>Fecha de Creación</th>
                <th>Imagen</th>
                <th>Operaciones</th>
            </tr>
            <?php foreach ($entradas as $entrada) : ?>
                <tr>
                    <td><?php echo $entrada['titulo']; ?></td>
                    <td><?php echo $entrada['contenido']; ?></td>
                    <td><?php echo $entrada['fecha_creacion']; ?></td>
                    <td><img src="<?php echo $entrada['imagen']; ?>" width="100" height="100" alt="Imagen de la entrada"></td>
                    <td>
                        <?php if ($_SESSION['perfil_usuario'] === 'admin') : ?>
                            <a href="editar_entrada.php?id=<?php echo $entrada['id']; ?>">Editar</a>
                            <a href="eliminar_entrada.php?id=<?php echo $entrada['id']; ?>">Eliminar</a>
                        <?php endif; ?>
                        <a href="detalle_entrada.php?id=<?php echo $entrada['id']; ?>">Detalle</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </center>
</body>

</html>
