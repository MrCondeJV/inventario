<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Directorio para el archivo de log
$log_dir = './assets/error/';
$log_file = $log_dir . 'php-error-' . date('Y-m-d') . '.log';

// Crear el directorio si no existe
if (!is_dir($log_dir)) {
    mkdir($log_dir, 0777, true);
}

// Configurar el archivo de log
ini_set('log_errors', 1);
ini_set('error_log', $log_file);

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

include "./conexion.php";

$usuario_id = $_POST['usuario_id'] ?? '';
$equipos = $_POST['equipos'] ?? [];

if (empty($equipos)) {
    error_log("No se encontraron datos de equipos en la solicitud.");
    header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
    exit();
}


$observaciones = $_POST['observaciones'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($usuario_id)) {
    $nombre_usuario = obtenerNombreUsuario($mysqli, $usuario_id);

    if (empty($nombre_usuario)) {
        error_log("No se encontró el usuario con ID: " . $usuario_id);
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }

    $usuario_stmt = $mysqli->prepare("SELECT nombre, cargo, unidad FROM usuarios_prestamo WHERE id = ?");
    $usuario_stmt->bind_param("i", $usuario_id);
    $usuario_stmt->execute();
    $usuario_result = $usuario_stmt->get_result();
    if ($usuario_row = $usuario_result->fetch_assoc()) {
        $cargo_usuario = $usuario_row['cargo'];
        $unidad_usuario = $usuario_row['unidad'];
    } else {
        error_log("No se encontraron detalles para el usuario ID: " . $usuario_id);
        header("Location: entregar_equipo.php?usuario_id=" . $usuario_id . "&error=1");
        exit();
    }
    $usuario_stmt->close();

    $prestamos = [];
    if ($stmt = $mysqli->prepare("
        SELECT dp.id, dp.serie_equipo, dp.cantidad_prestada 
        FROM detalles_prestamo dp
        INNER JOIN prestamos p ON dp.id_prestamo = p.id
        WHERE p.usuario_id = ? AND dp.Estado = 0
    ")) {
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

    $mysqli->begin_transaction();

    function generateUniqueLoanCode($mysqli)
    {
        $prefix = 'ENTREGA-'; // Prefijo para el código de ENTREGA
        $suffix = substr(md5(uniqid(mt_rand(), true)), 0, 6); // Sufijo único de 6 caracteres

        // Generar un código de ENTREGA único combinando prefijo y sufijo
        $cod_entrega = $prefix . $suffix;

        // Verificar si el código ya existe en la base de datos
        $check_stmt = $mysqli->prepare("SELECT COUNT(*) FROM entregas WHERE Cod_entrega = ?");
        $count = 0;
        $check_stmt->bind_param("s", $cod_entrega);
        $check_stmt->execute();
        $check_stmt->bind_result($count);
        $check_stmt->fetch();
        $check_stmt->close();

        // Si el código existe, generar uno nuevo recursivamente
        if ($count > 0) {
            return generateUniqueLoanCode($mysqli); // Llamada recursiva para generar otro código
        } else {
            return $cod_entrega; // Devuelve el código único generado
        }
    }

    $cod_entrega = generateUniqueLoanCode($mysqli);

    try {
        $fecha_entregado = date('Y-m-d H:i:s');
        $stmt_entrega = $mysqli->prepare("INSERT INTO entregas (Cod_entrega, usuario_id, Nombre_usuario, Fecha_entregado, observaciones) VALUES (?, ?, ?, ?, ? )");
        $stmt_entrega->bind_param("sisss", $cod_entrega, $usuario_id, $nombre_usuario, $fecha_entregado, $observaciones);
        if (!$stmt_entrega->execute()) {
            throw new Exception("Error al insertar en la tabla `entregas`: " . $stmt_entrega->error);
        }
        $id_entrega = $stmt_entrega->insert_id;
        $stmt_entrega->close();

        // Después de obtener los préstamos relacionados con el usuario
        foreach ($prestamos as $prestamo) {
            $prestamo_id = $prestamo['id'];
            $serie_equipo = $prestamo['serie_equipo'];
            $cantidad_entregada = $prestamo['cantidad_prestada'];

            // Obtener la placa del equipo prestado (por ejemplo, de `detalles_prestamo`)
            $stmt_placa = $mysqli->prepare("SELECT placa_equipo FROM detalles_prestamo WHERE id = ?");
            $stmt_placa->bind_param("i", $prestamo_id);
            $stmt_placa->execute();
            $stmt_placa->bind_result($placa_equipo);
            $stmt_placa->fetch();
            $stmt_placa->close();

            


            // Actualizar la cantidad en la tabla `equipos`
            if ($stmt = $mysqli->prepare("UPDATE equipos SET Cantidad = Cantidad + ? WHERE Serie = ?")) {
                $stmt->bind_param("is", $cantidad_entregada, $serie_equipo);
                if (!$stmt->execute()) {
                    throw new Exception("Error en la ejecución de la actualización de equipos: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de actualización de equipos: " . $mysqli->error);
            }

            $equipo_stmt = $mysqli->prepare("SELECT Serie, Nombre, Estado FROM equipos WHERE Serie = ?");
            $equipo_stmt->bind_param("s", $serie_equipo);
            $equipo_stmt->execute();
            $equipo_result = $equipo_stmt->get_result();
            $equipo_row = $equipo_result->fetch_assoc();
            $serie_equipo = $equipo_row['Serie'];
            $nombre_equipo = $equipo_row['Nombre'];

            $equipo_stmt->close();

            // Insertar el detalle de la entrega incluyendo `placa_equipo`
            if ($stmt_detalle = $mysqli->prepare("
        INSERT INTO detalles_entrega (id_entrega, usuario_id, Nombre_usuario, Serie_equipo, Equipo, Cantidad_entregada, placa_equipo, Estado)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Entregado')
    ")) {
                $stmt_detalle->bind_param("iisssss", $id_entrega, $usuario_id, $nombre_usuario, $serie_equipo, $nombre_equipo, $cantidad_entregada, $placa_equipo);
                if (!$stmt_detalle->execute()) {
                    throw new Exception("Error en la ejecución de la inserción de detalles de entrega: " . $stmt_detalle->error);
                }
                $stmt_detalle->close();
            } else {
                throw new Exception("Error en la preparación de la consulta de inserción de detalles de entrega: " . $mysqli->error);
            }

            // Eliminar el detalle del préstamo
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


        header("Location: index.php?entrega=exito");
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

function obtenerNombreUsuario($mysqli, $usuario_id)
{
    $nombre = null;
    if ($stmt = $mysqli->prepare("SELECT nombre FROM usuarios_prestamo WHERE id = ?")) {
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
