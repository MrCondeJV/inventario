<?php
include "./conexion.php";

$nombre_equipo = isset($_POST['nombre_equipo']) ? $_POST['nombre_equipo'] : '';
$sql_query = "SELECT * FROM historial_asignaciones";

if (!empty($nombre_equipo)) {
  $sql_query .= " WHERE Equipo LIKE '%$nombre_equipo%'";
}

$result = $mysqli->query($sql_query);
$output = '';

while ($datos = $result->fetch_object()) {
  $output .= '<tr>
                <td>' . $datos->id_asignacion . '</td>
                <td>' . $datos->Nombre_usuario . '</td>
                <td>
                  <a href="ver_detalles_asignaciones.php?id=' . $datos->id_asignacion . '">
                    <img src="assets/img/icons/eye.svg" alt="img" />
                  </a>';
  
  // Verificar si docPdf existe antes de usarlo
  if (isset($datos->docPdf)) {
    $output .= '<a href="uploads/' . $datos->docPdf . '" download>
                  <img src="assets/img/icons/download.svg" alt="img" />
                </a>';
  }

  $output .= '</td>
              </tr>';
}

echo $output;

