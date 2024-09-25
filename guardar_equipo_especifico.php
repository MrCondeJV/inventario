<?php
session_start();

// Mostrar errores durante el desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Directorio para el archivo de log
$log_dir = './assets/error/';
$log_file = $log_dir . 'php-error-' . date('Y-m-d') . '.log';

// Crear el directorio si no existe
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// Configurar el archivo de log
ini_set('log_errors', 1);
ini_set('error_log', $log_file);

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

try {
    // Obtener datos del formulario
    if (!isset($_POST['equipo_id']) || !isset($_POST['serial'])) {
        throw new Exception("Faltan datos necesarios.");
    }
    
    $equipo_id = $_POST['equipo_id'];
    $serial = $_POST['serial'];

    // Verificar si la serie ya existe en la base de datos, incluyendo los que estén deshabilitados
    $buscar_serie = $mysqli->prepare("SELECT habilitado FROM equipos_especificos WHERE serial = ?");
    if (!$buscar_serie) {
        throw new Exception("Error preparando la consulta: " . $mysqli->error);
    }

    $buscar_serie->bind_param("s", $serial);
    $buscar_serie->execute();
    $buscar_serie->bind_result($habilitado);
    $buscar_serie->fetch();
    $buscar_serie->close();

    // Si el serial ya existe pero está deshabilitado, lo habilitamos nuevamente
    if (isset($habilitado) && $habilitado == 0) {
        $sql = $mysqli->prepare("UPDATE equipos_especificos SET habilitado = 1 WHERE serial = ?");
        if (!$sql) {
            throw new Exception("Error preparando la consulta de actualización: " . $mysqli->error);
        }
        $sql->bind_param("s", $serial);

        if (!$sql->execute()) {
            throw new Exception("Error ejecutando la actualización de habilitado: " . $sql->error);
        }
        $sql->close();
        
        // Actualizar la cantidad de equipos
        $update_query = "
            UPDATE equipos e
            JOIN (
                SELECT id_equipo, COUNT(*) as total_especificos
                FROM equipos_especificos
                WHERE habilitado = 1
                GROUP BY id_equipo
            ) es ON e.id = es.id_equipo
            SET e.cantidad = es.total_especificos;
        ";

        if (!$mysqli->query($update_query)) {
            throw new Exception("Error actualizando la cantidad de equipos: " . $mysqli->error);
        }

        header("Location: productlist.php");
        exit();
    }

    // Si no existe, insertar el nuevo serial
    $sql = $mysqli->prepare("INSERT INTO equipos_especificos (id_equipo, serial, habilitado) VALUES (?, ?, 1)");
    if (!$sql) {
        throw new Exception("Error preparando la consulta de inserción: " . $mysqli->error);
    }
    $sql->bind_param("is", $equipo_id, $serial);

    if (!$sql->execute()) {
        throw new Exception("Error ejecutando la consulta de inserción: " . $sql->error);
    }
    $sql->close();

    // Actualizar la cantidad de equipos
    $update_query = "
        UPDATE equipos e
        JOIN (
            SELECT id_equipo, COUNT(*) as total_especificos
            FROM equipos_especificos
            WHERE habilitado = 1
            GROUP BY id_equipo
        ) es ON e.id = es.id_equipo
        SET e.cantidad = es.total_especificos;
    ";

    if (!$mysqli->query($update_query)) {
        throw new Exception("Error actualizando la cantidad de equipos: " . $mysqli->error);
    }

    // Redirigir a la lista de productos si todo va bien
    header("Location: productlist.php");
    exit();

} catch (Exception $e) {
    // Registrar el error en el archivo de log
    error_log($e->getMessage());
    
    // Redirigir a la página con un mensaje de error
    $_SESSION['error'] = "Hubo un problema al guardar el equipo: " . $e->getMessage();
    header("Location: addproducto.php");
    exit();
}
