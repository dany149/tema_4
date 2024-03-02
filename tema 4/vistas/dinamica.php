<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Obtener datos de usuarios
$stmtUsuarios = $conexion->query("SELECT id, nombre, apellido, email, perfil, imagen FROM Usuarios");
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);

// Obtener datos de entradas
$stmtEntradas = $conexion->query("SELECT id, titulo, fecha_creacion, contenido, imagen FROM Entradas ORDER BY fecha_creacion DESC");
$entradas = $stmtEntradas->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios y Entradas</title>
    <link rel="stylesheet" type="text/css" href="../css/css4.css">
</head>

<body>
    <center>
        <h2>Listado de Usuarios</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Imagen</th>
                <th>Operaciones</th>
            </tr>
            <?php foreach ($usuarios as $usuario) : ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['apellido']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['perfil']; ?></td>
                    <td><img src="<?php echo $usuario['imagen']; ?>" alt="Imagen de perfil" width="50"></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                        <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>
                        <a href="detalle_usuario.php?id=<?php echo $usuario['id']; ?>">Detalle</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br><br>
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
    </center>
</body>

</html>
