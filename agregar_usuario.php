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
  $documento = $_POST['Documento'];
  $nombre = $_POST['Nombre'];
  $cargo = $_POST['Cargo'];
  $unidad = $_POST['Unidad'];
  $usuario = $_POST['Usuario'];
  $contrasena = sha1($_POST['contrasena']); // Encriptación SHA1
  
  // ID_Rol
  $rol = $_POST['Rol']; // Asumiendo que el valor es enviado como opción select, captura el ID de rol adecuadamente
  
  // Preparar la consulta SQL para insertar el usuario
  $insertar_usuario = $mysqli->prepare("INSERT INTO usuarios (Documento, Nombre, Cargo, Unidad, Usuario, contrasena, ID_Rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $insertar_usuario->bind_param("ssssssi", $documento, $nombre, $cargo, $unidad, $usuario, $contrasena, $rol);
  
  // Ejecutar la consulta
  if ($insertar_usuario->execute()) {
    // Éxito al insertar
    $insertar_usuario->close();
    $_SESSION['success'] = "Usuario agregado correctamente.";
    header("Location: userlists.php");
    exit();
  } else {
    // Error al insertar
    $_SESSION['error'] = "Error al agregar el usuario.";
    header("Location: newuser.php");
    exit();
  }
  
  // Cerrar conexión
  $mysqli->close();
} else {
  // Redirigir si se intenta acceder al script sin método POST
  header("Location: newuser.php");
  exit();
}
?>
