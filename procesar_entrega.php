<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'];
$prestamo_id = $_POST['prestamo_id'];
$serie_equipo = $_POST['serie_equipo'];
$cantidad_entregada = $_POST['cantidad_entregada'];

// Actualizar la cantidad entregada en la tabla de equipos
if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
    $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
    $stmt->execute();
    $stmt->close();
}

// Registrar la entrega en la tabla entregas
if ($stmt = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, Nombre_usuario, Serie_equipo, Equipo, Cantidad_entregado, Fecha_entregado) VALUES (?, (SELECT Nombre FROM usuarios WHERE id = ?), ?, (SELECT Nombre FROM equipos WHERE Serie = ?), ?, NOW())")) {
    $cod_entrega = uniqid('ENTREGA_', true); // Generar un código único para la entrega
    $stmt->bind_param("sissi", $cod_entrega, $usuario_id, $serie_equipo, $serie_equipo, $cantidad_entregada);
    $stmt->execute();
    $stmt->close();
}

// Eliminar el registro de préstamo correspondiente
if ($stmt = $mysqli->prepare("DELETE FROM prestamos WHERE id = ?")) {
    $stmt->bind_param("i", $prestamo_id);
    $stmt->execute();
    $stmt->close();
}

header("Location: entregar_equipo.php?usuario_id=" . $usuario_id);
exit();
?>
