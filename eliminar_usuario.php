<?php
include "conexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $mysqli->query("DELETE FROM usuarios WHERE id = $id");

    if ($sql) {
        header("Location: userlists.php?msg=Usuario eliminado exitosamente");
    } else {
        header("Location: userlists.php?msg=Error al eliminar el Usuario");
    }
} else {
    header("Location: userlists.php?msg=ID de usuario no proporcionado");
}
?>
