<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'];

// Obtener todos los préstamos del usuario
$prestamos = [];
if ($stmt = $mysqli->prepare("SELECT id, Serie_equipo, Cantidad_prestada FROM detalles_prestamo WHERE id_prestamo = ?")) {
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar el número de filas devueltas
    if ($result->num_rows === 0) {
        // No hay préstamos encontrados para este usuario
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id);
        exit();
    }

    while ($row = $result->fetch_assoc()) {
        $prestamos[] = $row;
    }
    $stmt->close();
}

// Procesar cada préstamo para entrega
foreach ($prestamos as $prestamo) {
    $prestamo_id = $prestamo['id'];
    $serie_equipo = $prestamo['Serie_equipo'];
    $cantidad_entregada = $prestamo['Cantidad_prestada'];

    // Sumar la cantidad entregada de vuelta a la tabla de equipos
    if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
        $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
        $stmt->execute();
        $stmt->close();
    }

    // Registrar la entrega en la tabla entregas
    if ($stmt = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, Nombre_usuario, Serie_equipo, Equipo, Cantidad_entregado, Fecha_entregado) VALUES (?, ?, ?, (SELECT Nombre FROM equipos WHERE Serie = ?), ?, NOW())")) {
        $cod_entrega = uniqid('ENTREGA_', true); // Generar un código único para la entrega
        $nombre_usuario = obtenerNombreUsuario($mysqli, $usuario_id);
        $nombre_equipo = obtenerNombreEquipo($mysqli, $serie_equipo);

        $stmt->bind_param("ssisi", $cod_entrega, $nombre_usuario, $serie_equipo, $serie_equipo, $cantidad_entregada);
        $stmt->execute();
        $stmt->close();
    }

    // Eliminar el registro de prestamo correspondiente
    if ($stmt = $mysqli->prepare("DELETE FROM detalles_prestamo WHERE id = ?")) {
        $stmt->bind_param("i", $prestamo_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Función para obtener el nombre de usuario
function obtenerNombreUsuario($mysqli, $usuario_id) {
    $stmt = $mysqli->prepare("SELECT Nombre FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->bind_result($nombre);
    $stmt->fetch();
    $stmt->close();
    return $nombre;
}

// Función para obtener el nombre del equipo
function obtenerNombreEquipo($mysqli, $serie_equipo) {
    $stmt = $mysqli->prepare("SELECT Nombre FROM equipos WHERE Serie = ?");
    $stmt->bind_param("s", $serie_equipo);
    $stmt->execute();
    $stmt->bind_result($nombre);
    $stmt->fetch();
    $stmt->close();
    return $nombre;
}

header("Location: entregar_equipo.php?usuario_id=" . $usuario_id);
exit();
?>
