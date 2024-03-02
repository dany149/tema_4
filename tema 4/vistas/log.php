<?php
session_start();

include '../modelo/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

// Consulta los registros de logs
$stmt = $conexion->query("SELECT * FROM logs");
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Logs</title>
    <link rel="stylesheet" type="text/css" href="../css/css4.css">
</head>

<body>
    <center>
        <h2>Registro de Logs</h2>
        <table>
            <tr>
                <th>Fecha y Hora</th>
                <th>Usuario</th>
                <th>Tipo de Operación</th>
                <th>Operaciones</th>
            </tr>
            <?php foreach ($logs as $log) : ?>
                <tr>
                    <td><?php echo $log['fecha_hora']; ?></td>
                    <td><?php echo $log['usuario']; ?></td>
                    <td><?php echo $log['tipo_operacion']; ?></td>
                    <td>
                        <a href="eliminar_log.php?id=<?php echo $log['id']; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <br>
        
    </center>

    
</body>

</html>
