<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta SQL para evitar inyección de SQL
    $stmt = $mysqli->prepare("DELETE FROM equipos_especificos WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" indica que $id es un entero

    if ($stmt->execute()) {
        // Redirigir con mensaje de éxito
        header("Location: productlist.php?msg=" . urlencode("Equipo eliminado exitosamente"));

        // Actualizar la cantidad de equipos en la tabla `equipos`
        $update_query = "
    UPDATE equipos e
    JOIN (
        SELECT id_equipo, COUNT(*) as total_especificos
        FROM equipos_especificos
        GROUP BY id_equipo
    ) es ON e.id = es.id_equipo
    SET e.cantidad = es.total_especificos;
";

        if (!$mysqli->query($update_query)) {
            throw new Exception("Error actualizando la cantidad de equipos: " . $mysqli->error);
        }
    } else {
        // Redirigir con mensaje de error
        header("Location: productlist.php?msg=" . urlencode("Error al eliminar el equipo"));
    }

    $stmt->close(); // Cerrar la declaración preparada
} else {
    // Redirigir si no se proporciona un ID
    header("Location: productlist.php?msg=" . urlencode("ID de equipo no proporcionado"));
}
