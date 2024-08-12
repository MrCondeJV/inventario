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
    $nombre_usuario = obtenerNombreUsuario($mysqli, $usuario_id);

    if (empty($nombre_usuario)) {
        error_log("No se encontró el usuario con ID: " . $usuario_id);
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }

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

    $mysqli->begin_transaction();

    function generateUniqueLoanCode($mysqli) {
        $prefix = 'ENTREGA-'; // Prefijo para el código de ENTREGA
        $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); // Sufijo único de 6 caracteres
    
        // Generar un código de ENTREGA único combinando prefijo y sufijo
        $cod_entrega = $prefix . $suffix;
    
        // Verificar si el código ya existe en la base de datos
        $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM entregas WHERE Cod_entrega = ?");
        $count=0;
        $check_stmt->bind_param("s", $cod_entrega);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();
    
        // Si el código existe, generar uno nuevo recursivamente
        if ($count > 0) {
            return generateUniqueLoanCode($mysqli); // Llamada recursiva para generar otro código
        } else {
            return $cod_entrega; // Devuelve el código único generado
        }
    }

    $cod_entrega = generateUniqueLoanCode($mysqli);

    try {
        $fecha_entregado = date('Y-m-d H:i:s');
        $stmt_entrega = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, usuario_id, Nombre_usuario, Fecha_entregado, recomendaciones, observaciones) VALUES (?, ?, ?, ?, ?, ? )");
        $stmt_entrega->bind_param("sissss", $cod_entrega, $usuario_id, $nombre_usuario, $fecha_entregado, $recomendaciones, $observaciones);
        if (!$stmt_entrega->execute()) {
            throw new Exception("Error al insertar en la tabla `entregas`: " . $stmt_entrega->error);
        }
        $id_entrega = $stmt_entrega->insert_id;
        $stmt_entrega->close();

        foreach ($prestamos as $prestamo) {
            $prestamo_id = $prestamo['id'];
            $serie_equipo = $prestamo['serie_equipo'];
            $cantidad_entregada = $prestamo['cantidad_prestada'];

            if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
                $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la actualización de equipos: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de actualización de equipos: " . $mysqli->error);
            }

            $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Estado FROM equipos WHERE Serie = ?");
            $equipo_stmt->bind_param("i", $serie_equipo);
            $equipo_stmt->execute();
            $equipo_result = $equipo_stmt->get_result();
            $equipo_row = $equipo_result->fetch_assoc();
            $serie_equipo = $equipo_row['Serie'];
            $nombre_equipo = $equipo_row['Nombre'];

            $equipo_stmt->close();

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

        $mysqli->commit();

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
        $sheet->setCellValue('B6', $cod_entrega); // Código de Entrega
        $sheet->setCellValue('B8', $nombre_usuario); // Nombre de Usuario
        $sheet->setCellValue('B7', $fecha_entregado); // Fecha de Entrega
        $sheet->setCellValue('B26', $recomendaciones); // Recomendaciones Técnicas
        $sheet->setCellValue('B40', $observaciones); // Observaciones
        $sheet->setCellValue('J8', $cargo_usuario); // Cargo
        $sheet->setCellValue('B9', $unidad_usuario); // Unidad

        $equipos = json_decode($_POST['equipos'] ?? '[]', true);

        if (empty($equipos)) {
            error_log("No se encontraron datos de equipos en la solicitud.");
            header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
            exit();
        }
        // Insertar detalles de los equipos entregados
        $row = 3; // Comienza en la fila 10
        foreach ($equipos as $equipo) {
            $nombre_equipo = $equipo['nombre'];
            $cantidad_prestada = (int)$equipo['cantidad'];

            // Obtener detalles del equipo usando el nombre
            $equipo_stmt = $mysqli->prepare("SELECT Serie, Estado FROM equipos WHERE Nombre = ?");
            $equipo_stmt->bind_param("s", $nombre_equipo);
            $equipo_stmt->execute();
            $equipo_result = $equipo_stmt->get_result();
            $equipo_row = $equipo_result->fetch_assoc();
            $serie_equipo = $equipo_row['Serie'];
            $estado_equipo = $equipo_row['Estado'];
            $equipo_stmt->close();

            // Insertar datos del equipo en las celdas correspondientes
            $sheet->setCellValue('C' . (10 + $row), $nombre_equipo); // Nombre del Equipo
            $sheet->setCellValue('L' . (10 + $row), $serie_equipo); // Serie del Equipo
            $sheet->setCellValue('B' . (10 + $row), $cantidad_prestada); // Cantidad Prestada
            $sheet->setCellValue('N' . (10 + $row), $estado_equipo); // Estado del Equipo

            $row++; // Incrementar la fila para el siguiente equipo
        }

        // Guardar los cambios en una nueva plantilla de Excel con nombre único
        $newTemplatePath = './assets/actas/entregas/' . $cod_entrega . '.xlsx';
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($newTemplatePath);

        // Cambiar permisos en el archivo recién creado
        chmod($newTemplatePath, 0644); // Establecer permisos para lectura/escritura para el propietario y solo lectura para los demás

        // Redirigir o hacer cualquier otra operación después de guardar los datos en la plantilla
        header("Location: index.php?entrega=exito");
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
