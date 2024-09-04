<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Directorio para el archivo de log
ini_set('log_errors', 1);
$log_dir = './assets/error/';
$log_file = $log_dir . 'php-error-' . date('Y-m-d') . '.log';

// Crear el directorio si no existe
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// Configurar el archivo de log
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

// Obtén el nombre del usuario
$usuario_stmt = $mysqli->prepare("SELECT nombre, cargo, unidad FROM usuarios_prestamo WHERE id = ?");
$usuario_stmt->bind_param("i", $usuario_id);
$usuario_stmt->execute();
$usuario_result = $usuario_stmt->get_result();
$usuario_row = $usuario_result->fetch_assoc();
$nombre_usuario = $usuario_row['nombre'];
$cargo_usuario = $usuario_row['cargo'];
$unidad_usuario = $usuario_row['unidad'];
$usuario_stmt->close();

// Verificar disponibilidad de equipos
foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_asignada = (int)$equipo_data['cantidad'];

        // Obtener la cantidad disponible del equipo
        $equipo_stmt = $mysqli->prepare("SELECT Cantidad FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        if ($equipo_result->num_rows === 0) {
            echo "No se encontró el equipo con ID: $equipo_id";
            exit(); // Salir del script si no se encuentra el equipo
        }
        $equipo_row = $equipo_result->fetch_assoc();
        $cantidad_disponible = $equipo_row['Cantidad'];
        $equipo_stmt->close();

        // Verificar si la cantidad pedida es mayor que la disponible
        if ($cantidad_asignada > $cantidad_disponible) {
            echo "La cantidad solicitada para el equipo ID: $equipo_id excede la cantidad disponible.";
            exit(); // Salir del script si la cantidad excede la disponible
        }
    }
}

// Generar un código de asignación único
function generateUniqueAssignmentCode($mysqli) {
    $prefix = 'ASIGNACION-'; // Prefijo para el código de asignación
    $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); // Sufijo único de 6 caracteres

    // Generar un código de asignación único combinando prefijo y sufijo
    $codigo_asignacion = $prefix . $suffix;

    // Verificar si el código ya existe en la base de datos
    $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM asignaciones WHERE id_asignacion = ?");
    $count = 0;
    $check_stmt->bind_param("s", $codigo_asignacion);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    // Si el código existe, generar uno nuevo recursivamente
    if ($count > 0) {
        return generateUniqueAssignmentCode($mysqli); // Llamada recursiva para generar otro código
    } else {
        return $codigo_asignacion; // Devuelve el código único generado
    }
}

// Validación y subida del archivo PDF
$targetDir = "uploads/";
$fileName = basename($_FILES["archivo_pdf"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));


// Verificar si el archivo es un PDF
if ($fileType != "pdf") {
    ob_end_clean();
    echo "<script>
    alert('Solo se permiten archivos PDF.');
    document.location='asignar_equipo.php';
    </script>";
    exit;
}

// Subir el archivo al servidor
if (!move_uploaded_file($_FILES["archivo_pdf"]["tmp_name"], $targetFilePath)) {
    ob_end_clean();
    echo "<script>
    alert('Error al subir el archivo.');
    document.location='asignar_equipo.php';
    </script>";
    exit;
}

$codigo_asignacion = generateUniqueAssignmentCode($mysqli);

// Insertar la asignación en la tabla asignaciones
$asignacion_stmt = $mysqli->prepare("INSERT INTO asignaciones (id_asignacion, usuario_id, Nombre_usuario, Fecha_asignacion, Observaciones, docPdf) VALUES (?, ?, ?, ?, ?, ?)");
$asignacion_stmt->bind_param("sissss", $codigo_asignacion, $usuario_id, $nombre_usuario, $fecha_asignacion, $observaciones, $fileName);
$asignacion_stmt->execute();
$asignacion_id = $asignacion_stmt->insert_id;
$asignacion_stmt->close();

// Insertar detalles de la asignación en la tabla detalles_asignacion
foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_asignada = 1;
        $seriales = $equipo_data['seriales'] ?? [];

        // Obtener detalles del equipo
        $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Cantidad, Estado FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        if ($equipo_result->num_rows === 0) {
            echo "No se encontró el equipo con ID: $equipo_id";
            continue; // Pasar al siguiente equipo
        }
        $equipo_row = $equipo_result->fetch_assoc();
        $serie_equipo = $equipo_row['Serie'];
        $nombre_equipo = $equipo_row['Nombre'];
        $estado_equipo = $equipo_row['Estado'];
        $cantidad_disponible = $equipo_row['Cantidad'];
        $equipo_stmt->close();

        // Descontar la cantidad prestada de la cantidad disponible
        $nueva_cantidad = $cantidad_disponible - count($seriales);

        // Actualizar la cantidad disponible en la base de datos
        $actualizar_stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = ? WHERE id = ?");
        $actualizar_stmt->bind_param("ii", $nueva_cantidad, $equipo_id);
        if (!$actualizar_stmt->execute()) {
            error_log('Error al actualizar la cantidad del equipo: ' . $actualizar_stmt->error);
            echo 'Error al actualizar la cantidad del equipo: ' . $actualizar_stmt->error;
        }
        $actualizar_stmt->close();

        foreach ($seriales as $placa_equipo) {
            // Insertar detalle de asignación en la tabla detalles_asignacion
            $detalle_stmt = $mysqli->prepare("INSERT INTO detalles_asignacion (id_asignacion, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_asignada, placa_equipo, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if (!$detalle_stmt) {
                die('Error en la preparación de la consulta: ' . $mysqli->error);
            }
        
            $detalle_stmt->bind_param("iisssssi", $asignacion_id, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_asignada, $placa_equipo, $estado_equipo);
            
            // Verificar si la ejecución falla
            if (!$detalle_stmt->execute()) {
                // Registrar o mostrar el error
                error_log('Error al insertar detalle de asignación: ' . $detalle_stmt->error);
                echo 'Error al insertar detalle de asignación: ' . $detalle_stmt->error;
            } else {
                echo 'Registro insertado con éxito para el número de serie: ' . $serie_equipo . '<br>';
            }
            $detalle_stmt->close();
        }
    }
}
header("Location: index.php?asignacion=exito");


exit;

