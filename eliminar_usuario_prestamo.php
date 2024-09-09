<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $mysqli->prepare("DELETE FROM prestamos WHERE usuario_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $mysqli->prepare("DELETE FROM entregas WHERE usuario_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    $stmt = $mysqli->prepare("DELETE FROM usuarios_prestamo WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: userlists_prestamo.php?msg=" . urldecode("Usuario eliminado exitosamente"));
        } else {
            header("Location: userlists_prestamo.php?msg=" . urldecode("Error al eliminar el Usuario"));
        }
        $stmt->close();
    } else {
        header("Location: userlists_prestamo.php?msg=" . urldecode("Error al preparar la consulta SQL"));
    }
} else {
    header("Location: userlists_prestamo.php?msg=" . urldecode("ID de usuario no proporcionado"));
}

