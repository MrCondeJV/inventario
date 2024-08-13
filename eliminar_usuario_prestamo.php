<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $mysqli->query("DELETE FROM usuarios_prestamo WHERE id = $id");

    if ($sql) {
        header("Location: userlists_prestamo.php?msg=Usuario eliminado exitosamente");
    } else {
        header("Location: userlists_prestamo.php?msg=Error al eliminar el Usuario");
    }
} else {
    header("Location: userlists_prestamo.php?msg=ID de usuario no proporcionado");
}
?>
