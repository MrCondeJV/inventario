<?php
$mysqli = new mysqli('localhost', 'root', '', 'db_inventario_esfim');

if ($mysqli->connect_error) {
    die("Error de conexion: " . $mysqli->connect_error);
}
?>
