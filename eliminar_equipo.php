<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para evitar inyección de SQL
    $stmt = $mysqli->prepare("DELETE FROM equipos WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que $id es un entero

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: productlist.php?msg=" . urlencode("Equipo eliminado exitosamente"));
    } else {
        // Redirigir con mensaje de error
        header("Location: productlist.php?msg=" . urlencode("Error al eliminar el equipo"));
    }

    $stmt->close(); // Cerrar la declaración preparada
} else {
    // Redirigir si no se proporciona un ID
    header("Location: productlist.php?msg=" . urlencode("ID de equipo no proporcionado"));
}
