<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'];
$equipos = $_POST['equipos'];

foreach ($equipos as $equipo_id => $equipo) {
  if (isset($equipo['seleccionado']) && $equipo['seleccionado'] == '1') {
    $cantidad = (int)$equipo['cantidad'];
    
    // Aquí puedes insertar el préstamo en la base de datos
    $stmt = $mysqli->prepare("INSERT INTO prestamos (usuario_id, equipo_id, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $usuario_id, $equipo_id, $cantidad);
    $stmt->execute();
    $stmt->close();
    
    // También puedes actualizar la cantidad de equipos disponibles si es necesario
    $stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad - ? WHERE id = ?");
    $stmt->bind_param("ii", $cantidad, $equipo_id);
    $stmt->execute();
    $stmt->close();
  }
}

header("Location: index.php");
exit();
?>
