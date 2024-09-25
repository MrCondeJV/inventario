<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('log_errors', 1);
$log_dir = './assets/error/';
$log_file = $log_dir . 'php-error-' . date('Y-m-d') . '.log';

if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

ini_set('error_log', $log_file);

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'];
$equipos = $_POST['equipos'];
$fecha_asignacion = date('Y-m-d H:i:s');
$observaciones = $_POST['observaciones'];

$usuario_stmt = $mysqli->prepare("SELECT nombre, cargo, unidad FROM usuarios_prestamo WHERE id = ?");
$usuario_stmt->bind_param("i", $usuario_id);
$usuario_stmt->execute();
$usuario_result = $usuario_stmt->get_result();
$usuario_row = $usuario_result->fetch_assoc();
$nombre_usuario = $usuario_row['nombre'];
$cargo_usuario = $usuario_row['cargo'];
$unidad_usuario = $usuario_row['unidad'];
$usuario_stmt->close();

foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_asignada = (int)$equipo_data['cantidad'];

        $equipo_stmt = $mysqli->prepare("SELECT Cantidad FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        if ($equipo_result->num_rows === 0) {
            echo "No se encontró el equipo con ID: $equipo_id";
            exit(); 
        }
        $equipo_row = $equipo_result->fetch_assoc();
        $cantidad_disponible = $equipo_row['Cantidad'];
        $equipo_stmt->close();

        if ($cantidad_asignada > $cantidad_disponible) {
            echo "La cantidad solicitada para el equipo ID: $equipo_id excede la cantidad disponible.";
            exit(); 
        }
    }
}

function generateUniqueAssignmentCode($mysqli)
{
    $prefix = 'ASIGNACION-'; 
    $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); 
    $codigo_asignacion = $prefix . $suffix;

    $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM asignaciones WHERE id_asignacion = ?");
    $count = 0;
    $check_stmt->bind_param("s", $codigo_asignacion);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    if ($count > 0) {
        return generateUniqueAssignmentCode($mysqli); 
    } else {
        return $codigo_asignacion; 
    }
}

$targetDir = "uploads/";
$fileName = basename($_FILES["archivo_pdf"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

if ($fileType != "pdf") {
    ob_end_clean();
    echo "<script>
    alert('Solo se permiten archivos PDF.');
    document.location='asignar_equipo.php';
    </script>";
    exit;
}

if (!move_uploaded_file($_FILES["archivo_pdf"]["tmp_name"], $targetFilePath)) {
    ob_end_clean();
    echo "<script>
    alert('Error al subir el archivo.');
    document.location='asignar_equipo.php';
    </script>";
    exit;
}

$codigo_asignacion = generateUniqueAssignmentCode($mysqli);

$asignacion_stmt = $mysqli->prepare("INSERT INTO asignaciones (id_asignacion, usuario_id, Nombre_usuario, Fecha_asignacion, Observaciones, docPdf) VALUES (?, ?, ?, ?, ?, ?)");
$asignacion_stmt->bind_param("sissss", $codigo_asignacion, $usuario_id, $nombre_usuario, $fecha_asignacion, $observaciones, $fileName);
$asignacion_stmt->execute();
$asignacion_id = $asignacion_stmt->insert_id;
$asignacion_stmt->close();

foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_asignada = 1;
        $seriales = $equipo_data['seriales'] ?? [];

        $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Cantidad, Estado FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        if ($equipo_result->num_rows === 0) {
            echo "No se encontró el equipo con ID: $equipo_id";
            continue; 
        }
        $equipo_row = $equipo_result->fetch_assoc();
        $serie_equipo = $equipo_row['Serie'];
        $nombre_equipo = $equipo_row['Nombre'];
        $estado_equipo = $equipo_row['Estado'];
        $cantidad_disponible = $equipo_row['Cantidad'];
        $equipo_stmt->close();

        $nueva_cantidad = $cantidad_disponible - count($seriales);

        $actualizar_stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = ? WHERE id = ?");
        $actualizar_stmt->bind_param("ii", $nueva_cantidad, $equipo_id);
        if (!$actualizar_stmt->execute()) {
            error_log('Error al actualizar la cantidad del equipo: ' . $actualizar_stmt->error);
            echo 'Error al actualizar la cantidad del equipo: ' . $actualizar_stmt->error;
        }
        $actualizar_stmt->close();

        foreach ($seriales as $placa_equipo) {
            $detalle_stmt = $mysqli->prepare("INSERT INTO detalles_asignacion (id_asignacion, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_asignada, placa_equipo, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$detalle_stmt) {
                die('Error en la preparación de la consulta: ' . $mysqli->error);
            }

            $detalle_stmt->bind_param("iisssssi", $asignacion_id, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_asignada, $placa_equipo, $estado_equipo);

            if (!$detalle_stmt->execute()) {
                error_log('Error al insertar detalle de asignación: ' . $detalle_stmt->error);
                echo 'Error al insertar detalle de asignación: ' . $detalle_stmt->error;
            } else {
                echo 'Registro insertado con éxito en detalles_asignacion para el número de serie: ' . $serie_equipo . '<br>';
            }
            $detalle_stmt->close();

            $historial_stmt = $mysqli->prepare("INSERT INTO historial_asignaciones (id_asignacion, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_asignada, placa_equipo, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$historial_stmt) {
                die('Error en la preparación de la consulta para historial: ' . $mysqli->error);
            }

            $historial_stmt->bind_param("iisssssi", $asignacion_id, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_asignada, $placa_equipo, $estado_equipo);

            if (!$historial_stmt->execute()) {
                error_log('Error al insertar en historial_asignaciones: ' . $historial_stmt->error);
                echo 'Error al insertar en historial_asignaciones: ' . $historial_stmt->error;
            } else {
                echo 'Registro insertado con éxito en historial_asignaciones para el número de serie: ' . $serie_equipo . '<br>';
            }
            $historial_stmt->close();

            // Deshabilitar el equipo en la tabla equipos_especificos según su serial (placa_equipo)
            $deshabilitar_stmt = $mysqli->prepare("UPDATE equipos_especificos SET habilitado = 0 WHERE serial = ?");
            if (!$deshabilitar_stmt) {
                die('Error en la preparación de la consulta de deshabilitación: ' . $mysqli->error);
            }

            $deshabilitar_stmt->bind_param("s", $placa_equipo);

            if (!$deshabilitar_stmt->execute()) {
                error_log('Error al deshabilitar el equipo específico con serial: ' . $deshabilitar_stmt->error);
                echo 'Error al deshabilitar el equipo específico con serial: ' . $deshabilitar_stmt->error;
            } else {
                echo 'Equipo con serial ' . $placa_equipo . ' deshabilitado correctamente.<br>';
            }
            $deshabilitar_stmt->close();
        }

        
    }
}
header("Location: index.php?asignacion=exito");
exit;

