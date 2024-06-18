<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $mysqli->query("DELETE FROM equipos WHERE id = $id");

    if ($sql) {
        header("Location: productlist.php?msg=Equipo eliminado exitosamente");
    } else {
        header("Location: productlist.php?msg=Error al eliminar el equipo");
    }
} else {
    header("Location: productlist.php?msg=ID de equipo no proporcionado");
}
?>
