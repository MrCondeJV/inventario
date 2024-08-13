<?php
session_start();

if (!isset($_SESSION['id'])) {
  header("Location: login.php");
  exit();
}

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Incluir archivo de conexión a la base de datos
  include "./conexion.php";
  
  // Recibir y limpiar los datos del formulario
  $documento = $_POST['documento'];
  $nombre = $_POST['nombre'];
  $cargo = $_POST['cargo'];
  $unidad = $_POST['unidad'];

  

  
  // Preparar la consulta SQL para insertar el usuario
  $insertar_usuario = $mysqli->prepare("INSERT INTO usuarios_prestamo (documento, nombre, cargo, unidad) VALUES (?, ?, ?, ?)");
  $insertar_usuario->bind_param("ssss", $documento, $nombre, $cargo, $unidad);
  
  // Ejecutar la consulta
  if ($insertar_usuario->execute()) {
    // Éxito al insertar
    $insertar_usuario->close();
    $_SESSION['success'] = "Usuario agregado correctamente.";
    header("Location: userlists_prestamo.php");
    exit();
  } else {
    // Error al insertar
    $_SESSION['error'] = "Error al agregar el usuario.";
    header("Location: newuser_prestamo.php");
    exit();
  }
  
  // Cerrar conexión
  $mysqli->close();
} else {
  // Redirigir si se intenta acceder al script sin método POST
  header("Location: newuser_prestamo.php");
  exit();
}
?>
