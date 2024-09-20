<?php
include "./conexion.php";

// Verificar si se ha enviado una búsqueda
$nombre_equipo = isset($_POST['nombre_equipo']) ? $_POST['nombre_equipo'] : '';

$sql_query = "SELECT * FROM historial_asignaciones";

// Si se ha ingresado un nombre de equipo, agregar la cláusula WHERE
if (!empty($nombre_equipo)) {
    $sql_query .= " WHERE Nombre_equipo LIKE '%$nombre_equipo%'";
}

$sql = $mysqli->query($sql_query);
?>

<table class="table datanew">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código Asignación</th>
            <th>Asignado A</th>
            <th>Fecha Asignación</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($datos = $sql->fetch_object()) { ?>
            <tr>
                <td><?php echo $datos->id ?></td>
                <td><?php echo $datos->id_asignacion ?></td>
                <td><?php echo $datos->Nombre_usuario ?></td>
                <td><?php echo $datos->Fecha_asignacion ?></td>
                <td>
                    <a href="ver_detalles_asignaciones.php?id=<?php echo $datos->id; ?>">
                        <img src="assets/img/icons/eye.svg" alt="img" />
                    </a>
                    <a href="uploads/<?php echo $datos->docPdf ?>" download>
                        <img src="assets/img/icons/download.svg" alt="img" />
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
