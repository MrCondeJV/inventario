<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', './assets/error/php-error.log');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($usuario_id)) {
    // Obtener el nombre de usuario
    $nombre_usuario = obtenerNombreUsuario($mysqli, $usuario_id);

    // Obtener todos los préstamos del usuario según su ID
    $prestamos = [];
    if ($stmt = $mysqli->prepare("SELECT id, Serie_equipo, Cantidad_prestada FROM detalles_prestamo WHERE usuario_id = ?")) {
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $prestamos[] = $row;
        }
        $stmt->close();
    } else {
        error_log("Error en la preparación de la consulta de préstamos: " . $mysqli->error);
    }

    if (empty($prestamos)) {
        error_log("No se encontraron préstamos para el usuario ID: " . $usuario_id);
    }

    // Procesar cada préstamo para la entrega
    $mysqli->begin_transaction();

    try {
        foreach ($prestamos as $prestamo) {
            $prestamo_id = $prestamo['id'];
            $serie_equipo = $prestamo['Serie_equipo'];
            $cantidad_entregada = $prestamo['Cantidad_prestada'];

            // Sumar la cantidad entregada de vuelta a la tabla de equipos
            if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
                $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la actualización de equipos: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de actualización de equipos: " . $mysqli->error);
            }

            // Registrar la entrega en la tabla entregas
            if ($stmt = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, usuario_id, Nombre_usuario, Fecha_entregado) VALUES (?, ?, ?, NOW())")) {
                $cod_entrega = uniqid('ENTREGA_', true); // Generar un código único para la entrega
                $stmt->bind_param("sis", $cod_entrega, $usuario_id, $nombre_usuario);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la inserción de entregas: " . $stmt->error);
                }
                $stmt->close();

                // Obtener el último ID de entrega insertado
                $id_entrega = $mysqli->insert_id;

                // Registrar detalles de la entrega en detalles_entrega
                if ($stmt_detalle = $mysqli->prepare("INSERT INTO detalles_entrega (id_entrega, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_entregada, Estado) SELECT ?, ?, ?, Serie_equipo, Nombre, ?, 'Entregado' FROM equipos WHERE Serie = ?")) {
                    $stmt_detalle->bind_param("iisss", $id_entrega, $usuario_id, $nombre_usuario, $cantidad_entregada, $serie_equipo);
                    if (!$stmt_detalle->execute()) {
                        throw new Exception("Error en la ejecución de la inserción de detalles de entrega: " . $stmt_detalle->error);
                    }
                    $stmt_detalle->close();
                } else {
                    throw new Exception("Error en la preparación de la consulta de inserción de detalles de entrega: " . $mysqli->error);
                }
            } else {
                throw new Exception("Error en la preparación de la consulta de inserción de entregas: " . $mysqli->error);
            }

            // Eliminar el registro de préstamo correspondiente
            if ($stmt = $mysqli->prepare("DELETE FROM detalles_prestamo WHERE id = ?")) {
                $stmt->bind_param("i", $prestamo_id);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la eliminación de préstamo: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de eliminación de préstamo: " . $mysqli->error);
            }
        }

        $mysqli->commit();
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&success=1");
        exit();
    } catch (Exception $e) {
        $mysqli->rollback();
        error_log("Error procesando las devoluciones: " . $e->getMessage());
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }
} else {
    error_log("No se proporcionó el ID del usuario o el método de solicitud no es POST.");
    header("Location: entregar_equipo.php?error=1");
    exit();
}

function obtenerNombreUsuario($mysqli, $usuario_id) {
    $nombre = null;
    if ($stmt = $mysqli->prepare("SELECT nombre FROM usuarios WHERE id = ?")) {
        $stmt->bind_param("i", $usuario_id);
        if ($stmt->execute()) {
            $stmt->bind_result($nombre);
            if ($stmt->fetch()) {
                $stmt->close();
                return $nombre;
            } else {
                error_log("No se encontró un usuario con el ID: $usuario_id");
            }
        } else {
            error_log("Error al ejecutar la consulta: " . $stmt->error);
        }
        $stmt->close();
    } else {
        error_log("Error al preparar la consulta: " . $mysqli->error);
    }
    return $nombre;
}
?>
