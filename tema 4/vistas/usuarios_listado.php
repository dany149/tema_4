<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['perfil_usuario'] !== 'admin') {
    header('Location: login.php');
    exit();
}

try {
    $stmt = $conexion->query("SELECT * FROM Usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
    <link rel="stylesheet" type="text/css" href="../css/css4.css">
</head>

<body>
    <div class="container">
        <h2>Listado de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Imagen</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo $usuario['nombre']; ?></td>
                        <td><?php echo $usuario['apellido']; ?></td>
                        <td><?php echo $usuario['email']; ?></td>
                        <td><?php echo $usuario['perfil']; ?></td>
                        <td><img src="<?php echo $usuario['imagen']; ?>" alt="Imagen de perfil" width="100"></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>">Editar</a>
                            <a href="eliminar_usuario.php?id=<?php echo $usuario['id']; ?>">Eliminar</a>
                            <a href="detalle_usuario.php?id=<?php echo $usuario['id']; ?>">Detalle</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
