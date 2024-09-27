<?php
// Incluir la biblioteca TCPDF
require_once('./vendor/tcpdf/tcpdf.php');

// Crear una nueva instancia de TCPDF con formato horizontal
class MYPDF extends TCPDF {
    // Encabezado personalizado
  
    // Pie de página personalizado
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Crear el PDF
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ESFIM');
$pdf->SetTitle('Detalle Asignación');
$pdf->SetSubject('Reporte de Asignación');
$pdf->SetKeywords('TCPDF, PDF, Asignaciones');

// Agregar una página
$pdf->AddPage();

// Conectar a la base de datos
include "./conexion.php";

// Obtener el id_asignacion como parámetro de la URL o el formulario
$id_asignacion = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validar que el id_asignacion sea mayor que 0
if ($id_asignacion > 0) {
    // Preparar la consulta para obtener el registro de la asignación
    $stmt = $mysqli->prepare("SELECT * FROM asignaciones WHERE id = ?");
    $stmt->bind_param("i", $id_asignacion);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($row = $result->fetch_assoc()) {
        // Crear un encabezado para los detalles de la asignación
        $html = '<h2 style="color: #007bff;">Detalles de la Asignación</h2>';  // Título azul

        // Mostrar el Código de Asignación y Nombre de Usuario sin usar tablas
        $html .= '<p><strong>Código de Asignación: </strong>' . htmlspecialchars($row['id']) . '</p>';
        $html .= '<p><strong>Nombre del Usuario: </strong>' . htmlspecialchars($row['Nombre_usuario']) . '</p>';

        // Crear una tabla HTML para los equipos asignados
        $html .= '<h3 style="color: #007bff;">Equipos Asignados</h3>';  // Subtítulo azul
        $html .= '<table style="border: 1px solid #dee2e6; width: 100%;">';
        $html .= '<thead>';
        $html .= '<tr style="background-color: #007bff; color: #fff;">';  // Encabezado azul con texto blanco
        $html .= '<th><strong>Equipo</strong></th><th><strong>Placa</strong></th><th><strong>Cantidad</strong></th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        $stmt_equipos = $mysqli->prepare("SELECT Equipo, placa_equipo, Cantidad_asignada FROM historial_asignaciones WHERE id_asignacion = ?");
        $stmt_equipos->bind_param("i", $id_asignacion);
        $stmt_equipos->execute();
        $result_equipos = $stmt_equipos->get_result();

        // Verificar si hay equipos asignados
        if ($result_equipos->num_rows > 0) {
            while ($equipo = $result_equipos->fetch_assoc()) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($equipo['Equipo']) . '</td>';
                $html .= '<td>' . htmlspecialchars($equipo['placa_equipo']) . '</td>';
                $html .= '<td>' . htmlspecialchars($equipo['Cantidad_asignada']) . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><td colspan="3">No se encontraron equipos asignados para esta asignación.</td></tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';
    } else {
        $html = '<h2>Error</h2><p>No se encontraron registros para esta asignación.</p>';
    }

    // Agregar el contenido al PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Cerrar las consultas preparadas
    $stmt->close();
    $stmt_equipos->close();
} else {
    $html = '<h2>Error</h2><p>Asignación no válida.</p>';
    $pdf->writeHTML($html, true, false, true, false, '');
}

// Cerrar la conexión a la base de datos
$mysqli->close();

// Generar el PDF y mostrarlo en el navegador
$pdf->Output('Reporte_detalle_asignacion.pdf', 'I');
