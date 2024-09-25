<?php
include "./conexion.php";

if (isset($_POST['id'])) {
    $equipoId = $_POST['id'];

    if ($seriales_stmt = $mysqli->prepare("SELECT serial FROM equipos_especificos WHERE id_equipo = ? AND habilitado = 1")) {
        $seriales_stmt->bind_param("i", $equipoId);
        $seriales_stmt->execute();
        $seriales_result = $seriales_stmt->get_result();

        $seriales = [];
        while ($serial_row = $seriales_result->fetch_assoc()) {
            $seriales[] = htmlspecialchars($serial_row['serial']);
        }
        $seriales_stmt->close();

        echo json_encode($seriales); // Devuelve los seriales como JSON
    }
} else {
    echo json_encode([]); // Si no hay ID, devuelve un array vacío
}
