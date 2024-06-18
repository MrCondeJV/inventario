<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

// Incluir archivo de conexión a la base de datos
include "./conexion.php";

// Verificar si se recibió el ID del equipo a modificar
if (!isset($_POST['id'])) {
  $_SESSION['error'] = "No se ha proporcionado un ID de equipo válido.";
  header("Location: productlist.php");
  exit();
}

// Recibir el ID del equipo desde el formulario
$id_equipo = $_POST['id'];

// Recibir datos del formulario
$serie = $_POST['Serie'];
$nombre = $_POST['Nombre'];
$categoria = $_POST['Categoria'];
$estado = $_POST['Estado'];
$cantidad = $_POST['Cantidad'];

// Actualizar los datos del equipo excepto la imagen
$actualizar_equipo = $mysqli->prepare("UPDATE equipos SET Serie = ?, Nombre = ?, Categoria = ?, Estado = ?, Cantidad = ? WHERE id = ?");
$actualizar_equipo->bind_param("sssssi", $serie, $nombre, $categoria, $estado, $cantidad, $id_equipo);
$actualizar_equipo->execute();
$actualizar_equipo->close();

// Procesar la imagen solo si se ha subido una nueva imagen
if ($_FILES['Imagen']['size'] > 0) {
  $imagen_nombre = $_FILES['Imagen']['name'];
  $imagen_temp = $_FILES['Imagen']['tmp_name'];
  $imagen_destino = 'assets/img/equipos/' . $imagen_nombre;

  // Mover la imagen al directorio deseado
  move_uploaded_file($imagen_temp, $imagen_destino);

  // Actualizar la imagen en la base de datos
  $actualizar_imagen = $mysqli->prepare("UPDATE equipos SET Imagen = ? WHERE id = ?");
  $actualizar_imagen->bind_param("si", $imagen_destino, $id_equipo);
  $actualizar_imagen->execute();
  $actualizar_imagen->close();
}

// Redireccionar a la lista de equipos después de actualizar
header("Location: productlist.php");
exit();
?>
