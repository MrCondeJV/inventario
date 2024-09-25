<!-- guardar_equipo.php -->

<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

// Conexión a la base de datos (suponiendo que tienes un archivo de conexión)
include "./conexion.php";

// Recibir datos del formulario
$serie = $_POST['Serie'];
$nombre = $_POST['Nombre'];
$categoria = $_POST['Categoria'];
$estado = $_POST['Estado'];
$cantidad = $_POST['Cantidad'];

// Procesar la imagen
$imagen_nombre = $_FILES['Imagen']['name'];
$imagen_temp = $_FILES['Imagen']['tmp_name'];
$imagen_destino = 'assets/img/equipos/' . $imagen_nombre;

// Verificar si la Serie ya existe
$buscar_serie = $mysqli->prepare("SELECT Serie FROM equipos WHERE Serie = ?");
$buscar_serie->bind_param("s", $serie);
$buscar_serie->execute();
$buscar_serie->store_result();

if ($buscar_serie->num_rows > 0) {
  $buscar_serie->close();
  $_SESSION['error'] = "Ya existe un equipo con la Serie ingresada.";
 
}

$buscar_serie->close();

// Mover la imagen al directorio deseado
move_uploaded_file($imagen_temp, $imagen_destino);

// Insertar datos en la base de datos
$insertar_equipo = $mysqli->prepare("INSERT INTO equipos (Serie, Nombre, Categoria, Estado, Imagen) VALUES (?, ?, ?, ?, ?)");
$insertar_equipo->bind_param("sssss", $serie, $nombre, $categoria, $estado, $imagen_destino);
$insertar_equipo->execute();
$insertar_equipo->close();

//Actualizar cantidad de equipos


// Redireccionar a la lista de equipos después de guardar
header("Location: productlist.php");
exit();
?>
