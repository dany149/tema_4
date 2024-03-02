<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// cantidad de registros por página
$registrosPorPagina = 3;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$inicio = ($page - 1) * $registrosPorPagina;
$totalEntradas = $conexion->query("SELECT COUNT(*) as total FROM Entradas")->fetch(PDO::FETCH_ASSOC)['total'];
$totalPaginas = ceil($totalEntradas / $registrosPorPagina);

// datos
$stmtEntradas = $conexion->prepare("SELECT id, titulo, fecha_creacion, contenido, imagen FROM Entradas ORDER BY fecha_creacion DESC LIMIT :inicio, :registrosPorPagina");
$stmtEntradas->bindParam(':inicio', $inicio, PDO::PARAM_INT);
$stmtEntradas->bindParam(':registrosPorPagina', $registrosPorPagina, PDO::PARAM_INT);
$stmtEntradas->execute();
$entradas = $stmtEntradas->fetchAll(PDO::FETCH_ASSOC);
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
                <th>Fecha de Creación</th>
                <th>Contenido</th>
                <th>Imagen</th>
                <th>Operaciones</th>
            </tr>
            <?php foreach ($entradas as $entrada) : ?>
                <tr>
                    <td><?php echo $entrada['titulo']; ?></td>
                    <td><?php echo $entrada['fecha_creacion']; ?></td>
                    <td><?php echo $entrada['contenido']; ?></td>
                    <td><img src="<?php echo $entrada['imagen']; ?>" alt="Imagen de entrada" width="50"></td>
                    <td>
                        <a href="editar_entrada.php?id=<?php echo $entrada['id']; ?>">Editar</a>
                        <a href="eliminar_entrada.php?id=<?php echo $entrada['id']; ?>">Eliminar</a>
                        <a href="detalle_entrada.php?id=<?php echo $entrada['id']; ?>">Detalle</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Paginación -->
        <div>
            <?php if ($page > 1) : ?>
                <a href="?page=<?php echo ($page - 1); ?>">Anterior</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>

            <?php if ($page < $totalPaginas) : ?>
                <a href="?page=<?php echo ($page + 1); ?>">Siguiente</a>
            <?php endif; ?>
        </div>
    </center>
</body>

</html>
