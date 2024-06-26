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

// Generar un código de préstamo único
function generateUniqueLoanCode($mysqli) {
    $prefix = 'PR-'; // Prefijo para el código de préstamo
    $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); // Sufijo único de 6 caracteres

    // Generar un código de préstamo único combinando prefijo y sufijo
    $codigo_prestamo = $prefix . $suffix;

    // Verificar si el código ya existe en la base de datos
    $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM prestamos WHERE Cod_prestamo = ?");
    $count=0;
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

// Insertar el préstamo en la tabla prestamos
$prestamo_stmt = $mysqli->prepare("INSERT INTO prestamos (Cod_prestamo, Nombre_usuario, Fecha_prestamo, Recomendaciones, Observaciones) VALUES (?, ?, ?, ?, ?)");
$prestamo_stmt->bind_param("sssss", $codigo_prestamo, $nombre_usuario, $fecha_prestamo, $recomendaciones, $observaciones);
$prestamo_stmt->execute();
$prestamo_id = $prestamo_stmt->insert_id;
$prestamo_stmt->close();

// Insertar detalles del préstamo en la tabla detalle_prestamo
foreach ($equipos as $equipo_id => $equipo_data) {
    if (isset($equipo_data['seleccionado'])) {
        $cantidad_prestada = (int)$equipo_data['cantidad'];

        // Obtener detalles del equipo
        $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Estado FROM equipos WHERE id = ?");
        $equipo_stmt->bind_param("i", $equipo_id);
        $equipo_stmt->execute();
        $equipo_result = $equipo_stmt->get_result();
        $equipo_row = $equipo_result->fetch_assoc();
        $serie_equipo = $equipo_row['Serie'];
        $nombre_equipo = $equipo_row['Nombre'];
        $estado_equipo = $equipo_row['Estado'];
        $equipo_stmt->close();

        // Insertar detalle de préstamo en la tabla detalle_prestamo
        $detalle_stmt = $mysqli->prepare("INSERT INTO detalles_prestamo (id_prestamo, Serie_equipo, Equipo, Cantidad_prestada, Estado) VALUES (?, ?, ?, ?, ?)");
        $detalle_stmt->bind_param("isssi", $prestamo_id, $serie_equipo, $nombre_equipo, $cantidad_prestada, $estado_equipo);
        $detalle_stmt->execute();
        $detalle_stmt->close();

        // Actualizar la cantidad en la tabla equipos
        $update_stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad - ? WHERE id = ?");
        $update_stmt->bind_param("ii", $cantidad_prestada, $equipo_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
}

// Redirigir o hacer cualquier otra operación después de guardar los datos en la base de datos
header("Location: index.php?prestamo=exito");
exit();
?>
