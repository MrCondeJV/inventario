<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

   
    $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: userlists.php?msg=" . urlencode("Usuario eliminado exitosamente"));
        } else {
            header("Location: userlists.php?msg=" . urlencode("Error al eliminar el Usuario"));
        }
        $stmt->close();
    } else {
        header("Location: userlists.php?msg=" . urlencode("Error al preparar la consulta SQL"));
    }
} else {
    header("Location: userlists.php?msg=" . urlencode("ID de usuario no proporcionado"));
}
?>
