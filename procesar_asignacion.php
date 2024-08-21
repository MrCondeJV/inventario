<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Crear el directorio si no existe
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}
// Directorio para el archivo de log
ini_set('log_errors', 1);
$log_dir = './assets/error/';
$log_file = $log_dir . 'php-error-' . date('Y-m-d') . '.log';

// Configurar el archivo de log

ini_set('error_log', $log_file);


if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";
require './vendor/autoload.php'; // Incluir la biblioteca PhpSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

$usuario_id = $_POST['usuario_id'];
$equipos = $_POST['equipos'];
$fecha_prestamo = date('Y-m-d H:i:s');
$recomendaciones = $_POST['recomendaciones'];
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
        $cantidad_prestada = (int)$equipo_data['cantidad'];

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
        if ($cantidad_prestada > $cantidad_disponible) {
            echo "La cantidad solicitada para el equipo ID: $equipo_id excede la cantidad disponible.";
            exit(); // Salir del script si la cantidad excede la disponible
        }
    }
}

// Generar un código de préstamo único
function generateUniqueLoanCode($mysqli) {
    $prefix = 'ASIGNACION-'; // Prefijo para el código de préstamo
    $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); // Sufijo único de 6 caracteres

    // Generar un código de préstamo único combinando prefijo y sufijo
    $codigo_prestamo = $prefix . $suffix;

    // Verificar si el código ya existe en la base de datos
    $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM equipos_asignados WHERE id_asignacion = ?");
    $count = 0;
    $check_stmt->bind_param("s", $codigo_prestamo);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close();

    // Si el código existe, generar uno nuevo recursivamente
    if ($count > 0) {
        return generateUniqueLoanCode($mysqli); // Llamada recursiva para generar otro código
    } else {
        return $codigo_prestamo; // Devuelve el código único generado
    }
}

$codigo_prestamo = generateUniqueLoanCode($mysqli);



// Insertar detalles del préstamo en la tabla detalle_prestamo
foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_prestada = 1;
        $seriales = $equipo_data['seriales'] ?? [];

        
            // Obtener detalles del equipo
            $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Estado FROM equipos WHERE id = ?");
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
            $equipo_stmt->close();

            foreach ($seriales as $placa_equipo) {
                // Insertar detalle de préstamo en la tabla detalle_prestamo
                $detalle_stmt = $mysqli->prepare("INSERT INTO detalles_prestamo (id_prestamo, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_prestada, placa_equipo, Estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                if (!$detalle_stmt) {
                    die('Error en la preparación de la consulta: ' . $mysqli->error);
                }
            
                $detalle_stmt->bind_param("iisssssi", $prestamo_id, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_prestada, $placa_equipo, $estado_equipo);
                
                // Verificar si la ejecución falla
                if (!$detalle_stmt->execute()) {
                    // Registrar o mostrar el error
                    error_log('Error al insertar detalle de préstamo: ' . $detalle_stmt->error);
                    echo 'Error al insertar detalle de préstamo: ' . $detalle_stmt->error;
                } else {
                    echo 'Registro insertado con éxito para el número de serie: ' . $serie_equipo . '<br>';
                }
                $detalle_stmt->close();
            }
            
        
    }
}




// Ruta de la plantilla de Excel existente
$templatePath = './assets/actas/PRESTAMO.xlsx';

// Cargar la plantilla de Excel
$spreadsheet = IOFactory::load($templatePath);
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('B6', $codigo_prestamo);
$sheet->setCellValue('B8', $nombre_usuario); 
$sheet->setCellValue('B7', $fecha_prestamo); 
$sheet->setCellValue('B26', $recomendaciones); 
$sheet->setCellValue('B40', $observaciones); 
$sheet->setCellValue('J8', $cargo_usuario); 
$sheet->setCellValue('B9', $unidad_usuario); 

$row = 3; 

// Insertar los datos en la hoja de Excel
foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_prestada = (int)$equipo_data['cantidad'];

     
        $equipo_stmt = $mysqli->prepare("SELECT Nombre, Serie, Estado  FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        $equipo_row = $equipo_result->fetch_assoc();
        $nombre_equipo = $equipo_row['Nombre'];
        $serie_equipo = $equipo_row['Serie'];
        $estado_equipo = $equipo_row['Estado'];
        $equipo_stmt->close();

        
        $sheet->setCellValue('C' . (10 + $row), $nombre_equipo); 
        $sheet->setCellValue('L' . (10 + $row), $serie_equipo); 
        $sheet->setCellValue('B' . (10 + $row), $cantidad_prestada); 
        $sheet->setCellValue('N' . (10 + $row), $estado_equipo); 

        $row++; 
    }
}

$newTemplatePath = './assets/actas/prestamos/' . $codigo_prestamo . '.xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($newTemplatePath);

chmod($newTemplatePath, 0644); 

// Redirigir o hacer cualquier otra operación después de guardar los datos en la plantilla
header("Location: index.php?prestamo=exito");
exit();
?>