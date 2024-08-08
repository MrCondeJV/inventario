<?php
session_start();

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

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";
require './vendor/autoload.php'; // Incluir la biblioteca PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;

$usuario_id = $_POST['usuario_id'] ?? '';
$equipos = $_POST['equipos'] ?? [];

if (empty($equipos)) {
    error_log("No se encontraron datos de equipos en la solicitud.");
    header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
    exit();
}

$recomendaciones = $_POST['recomendaciones'] ?? '';
$observaciones = $_POST['observaciones'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($usuario_id)) {
    // Obtener el nombre de usuario
    $nombre_usuario = obtenerNombreUsuario($mysqli, $usuario_id);

    if (empty($nombre_usuario)) {
        error_log("No se encontró el usuario con ID: " . $usuario_id);
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }

    // Obtener más detalles del usuario
    $usuario_stmt = $mysqli->prepare("SELECT nombre, cargo, unidad FROM usuarios WHERE id = ?");
    $usuario_stmt->bind_param("i", $usuario_id);
    $usuario_stmt->execute();
    $usuario_result = $usuario_stmt->get_result();
    if ($usuario_row = $usuario_result->fetch_assoc()) {

        $cargo_usuario = $usuario_row['cargo'];
        $unidad_usuario = $usuario_row['unidad'];
    } else {
        error_log("No se encontraron detalles para el usuario ID: " . $usuario_id);
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }
    $usuario_stmt->close();

    // Generar código de entrega
    $cod_entrega = uniqid('ENTREGA-', true);

    // Obtener todos los préstamos del usuario según su ID
    $prestamos = [];
    if ($stmt = $mysqli->prepare("
        SELECT dp.id, dp.serie_equipo, dp.cantidad_prestada 
        FROM detalles_prestamo dp
        INNER JOIN prestamos p ON dp.id_prestamo = p.id
        WHERE p.usuario_id = ? AND dp.Estado = 0
    ")) {
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $prestamos[] = $row;
        }
        $stmt->close();
    } else {
        error_log("Error en la preparación de la consulta de préstamos: " . $mysqli->error);
    }

    if (empty($prestamos)) {
        error_log("No se encontraron préstamos para el usuario ID: " . $usuario_id);
    }

    // Iniciar una transacción
    $mysqli->begin_transaction();

    try {
        // Insertar el registro en la tabla `entregas` y obtener `id_entrega`
        $fecha_entregado = date('Y-m-d H:i:s');
        $stmt_entrega = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, usuario_id, Nombre_usuario, Fecha_entregado, recomendaciones, observaciones) VALUES (?, ?, ?, ?, ?, ? )");
        $stmt_entrega->bind_param("sissss", $cod_entrega, $usuario_id, $nombre_usuario, $fecha_entregado, $recomendaciones, $observaciones);
        if (!$stmt_entrega->execute()) {
            throw new Exception("Error al insertar en la tabla `entregas`: " . $stmt_entrega->error);
        }
        $id_entrega = $stmt_entrega->insert_id; // Obtener el ID del registro recién insertado
        $stmt_entrega->close();

        // Procesar cada préstamo para la entrega
        foreach ($prestamos as $prestamo) {
            $prestamo_id = $prestamo['id'];
            $serie_equipo = $prestamo['serie_equipo'];
            $cantidad_entregada = $prestamo['cantidad_prestada'];

            // Sumar la cantidad entregada de vuelta a la tabla de equipos
            if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
                $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la actualización de equipos: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de actualización de equipos: " . $mysqli->error);
            }

            // Obtener detalles del equipo
            $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Estado FROM equipos WHERE Serie = ?");
            $equipo_stmt->bind_param("i", $serie_equipo);
            $equipo_stmt->execute();
            $equipo_result = $equipo_stmt->get_result();
            $equipo_row = $equipo_result->fetch_assoc();
            $serie_equipo = $equipo_row['Serie'];
            $nombre_equipo = $equipo_row['Nombre'];

            $equipo_stmt->close();

            // Registrar la entrega en la tabla `detalles_entrega`
            if ($stmt_detalle = $mysqli->prepare("
INSERT INTO detalles_entrega (id_entrega, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_entregada, Estado)
VALUES (?, ?, ?, ?, ?, ?, 'Entregado')
")) {
                $stmt_detalle->bind_param("iisssi", $id_entrega, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_entregada);
                if (!$stmt_detalle->execute()) {
                    throw new Exception("Error en la ejecución de la inserción de detalles de entrega: " . $stmt_detalle->error);
                }
                $stmt_detalle->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de inserción de detalles de entrega: " . $mysqli->error);
            }


            // Eliminar el registro de préstamo correspondiente
            if ($stmt = $mysqli->prepare("DELETE FROM detalles_prestamo WHERE id = ?")) {
                $stmt->bind_param("i", $prestamo_id);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la eliminación de préstamo: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de eliminación de préstamo: " . $mysqli->error);
            }
        }

        // Confirmar la transacción
        $mysqli->commit();
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&success=1");
        exit();
    } catch (Exception $e) {
        $mysqli->rollback();
        error_log("Error procesando las devoluciones: " . $e->getMessage());
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }
} else {
    error_log("No se proporcionó el ID del usuario o el método de solicitud no es POST.");
    header("Location: entregar_equipo.php?error=1");
    exit();
}

function obtenerNombreUsuario($mysqli, $usuario_id)
{
    $nombre = null;
    if ($stmt = $mysqli->prepare("SELECT nombre FROM usuarios WHERE id = ?")) {
        $stmt->bind_param("i", $usuario_id);
        if ($stmt->execute()) {
            $stmt->bind_result($nombre);
            if ($stmt->fetch()) {
                $stmt->close();
                return $nombre;
            } else {
                error_log("No se encontró un usuario con el ID: $usuario_id");
            }
        } else {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Error al preparar la consulta: " . $mysqli->error);
    }
    return $nombre;
}

// Ruta de la plantilla de Excel existente
$templatePath = './assets/actas/ENTREGA.xlsx';

// Comprobar si la plantilla existe
if (!file_exists($templatePath)) {
    error_log("La plantilla de Excel no se encontró en la ruta: " . $templatePath);
    header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
    exit();
}

// Cargar la plantilla de Excel
try {
    $spreadsheet = IOFactory::load($templatePath);
} catch (Exception $e) {
    error_log("Error al cargar la plantilla de Excel: " . $e->getMessage());
    header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
    exit();
}

// Seleccionar la primera hoja de la plantilla
$sheet = $spreadsheet->getActiveSheet();

// Insertar datos en las celdas correspondientes
$sheet->setCellValue('A2', $cod_entrega); // Código de Entrega
$sheet->setCellValue('B8', $nombre_usuario); // Nombre de Usuario
$sheet->setCellValue('B7', $fecha_entregado); // Fecha de Entrega
$sheet->setCellValue('B26', $recomendaciones); // Recomendaciones Técnicas
$sheet->setCellValue('B40', $observaciones); // Observaciones
$sheet->setCellValue('J8', $cargo_usuario); // Cargo
$sheet->setCellValue('B9', $unidad_usuario); // Unidad

// Insertar detalles de los equipos entregados
$row = 3;
foreach ($prestamos as $index => $equipo) {
    $sheet->setCellValue('A' . $row, $index + 1);
    $sheet->setCellValue('B' . $row, $equipo['serie_equipo']);
    $sheet->setCellValue('C' . $row, $equipo['cantidad_prestada']);
    $row++;
}

// Generar el archivo Excel
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

// Nombre y ruta del archivo de salida
$filename = 'Acta_de_Entrega_' . $nombre_usuario . '.xlsx';
$outputFilePath = './assets/actas_generadas/' . $filename;

// Guardar el archivo
try {
    $writer->save($outputFilePath);
} catch (Exception $e) {
    error_log("Error al guardar el archivo de Excel: " . $e->getMessage());
    header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
    exit();
}

// Redirigir a la descarga del archivo o mostrar un mensaje de éxito
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . basename($outputFilePath) . '"');
header('Content-Length: ' . filesize($outputFilePath));
readfile($outputFilePath);
exit();
