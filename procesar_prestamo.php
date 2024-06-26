<?php
session_start();

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
$usuario_stmt = $mysqli->prepare("SELECT nombre, cargo, unidad FROM usuarios WHERE id = ?");
$usuario_stmt->bind_param("i", $usuario_id);
$usuario_stmt->execute();
$usuario_result = $usuario_stmt->get_result();
$usuario_row = $usuario_result->fetch_assoc();
$nombre_usuario = $usuario_row['nombre'];
$cargo_usuario = $usuario_row['cargo'];
$unidad_usuario = $usuario_row['unidad'];
$usuario_stmt->close();

// Ruta de la plantilla de Excel existente
$templatePath = './assets/actas/PRESTAMO.xlsx';

// Cargar la plantilla de Excel
$spreadsheet = IOFactory::load($templatePath);
$sheet = $spreadsheet->getActiveSheet();

// Encuentra las celdas donde deseas insertar los datos
$sheet->setCellValue('A2', uniqid('PR-', true)); // Código de Préstamo
$sheet->setCellValue('B8', $nombre_usuario); // Nombre de Usuario
$sheet->setCellValue('B7', $fecha_prestamo); // Fecha de Préstamo
$sheet->setCellValue('B26', $recomendaciones); // Recomendaciones Técnicas
$sheet->setCellValue('B40', $observaciones); // Observaciones
$sheet->setCellValue('J8', $cargo_usuario); // Cargo
$sheet->setCellValue('B9', $unidad_usuario); // Unidad

$row = 3; // Fila inicial para los datos de equipos

foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_prestada = (int)$equipo_data['cantidad'];

        // Obtener detalles del equipo
        $equipo_stmt = $mysqli->prepare("SELECT Nombre, Serie, Estado  FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        $equipo_row = $equipo_result->fetch_assoc();
        $nombre_equipo = $equipo_row['Nombre'];
        $serie_equipo = $equipo_row['Serie'];
        $estado_equipo = $equipo_row['Estado'];
        $equipo_stmt->close();

        // Insertar datos del equipo en las celdas correspondientes
        $sheet->setCellValue('C' . (10 + $row), $nombre_equipo); // Nombre del Equipo
        $sheet->setCellValue('L' . (10 + $row), $serie_equipo); // Serie del Equipo
        $sheet->setCellValue('B' . (10 + $row), $cantidad_prestada); // Cantidad Prestada
        $sheet->setCellValue('N' . (10 + $row), $estado_equipo); // Cantidad Prestada


        $row++; // Incrementar la fila para el siguiente equipo
    }
}

// Guardar los cambios en una nueva plantilla de Excel con nombre único
$newTemplatePath = './assets/actas/PRESTAMO_' . uniqid() . '.xlsx';
$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save($newTemplatePath);

// Cambiar permisos en el archivo recién creado (ejemplo de permisos)
chmod($newTemplatePath, 0644); // Establecer permisos para lectura/escritura para el propietario y solo lectura para los demás

// Redirigir o hacer cualquier otra operación después de guardar los datos en la plantilla
header("Location: index.php?prestamo=exito");
exit();
?>
