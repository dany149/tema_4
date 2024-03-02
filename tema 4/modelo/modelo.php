<?php
function conectarBD() {
    $host = "localhost";
    $usuario = "root";
    $contrasena = "";
    $base_datos = "bdblog";

    try {
        $conexion = new PDO("mysql:host=$host;dbname=$base_datos", $usuario, $contrasena);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conexion->exec("SET NAMES utf8");
        return $conexion;
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        die();
    }
}

function iniciarSesion($usuario, $contrasena) {
    $conexion = conectarBD();

    try {
        $stmt = $conexion->prepare("SELECT id, perfil, password FROM usuarios WHERE nombre = :usuario");
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && password_verify($contrasena, $resultado['password'])) {
            return [
                'id' => $resultado['id'],
                'perfil' => $resultado['perfil']
            ];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        die();
    }
}
?>
