<?php
// Incluir la biblioteca TCPDF
require_once('./vendor/tcpdf/tcpdf.php');

// Crear una nueva instancia de TCPDF con formato horizontal
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ESFIM');
$pdf->SetTitle('Informe Dvoluciones');
$pdf->SetSubject('Sujeto del PDF');
$pdf->SetKeywords('TCPDF, PDF, ejemplo, prueba');

// Agregar una página
$pdf->AddPage();

// Conectar a la base de datos y recuperar los registros de la tabla historial
include "./conexion.php";

$sql = "SELECT * FROM entregas";
$result = $mysqli->query($sql);

// Crear una tabla HTML para mostrar los registros
$html = '<h1 style="font-family: Nunito, sans-serif;">Informe General de Devoluciones</h1>';
$html .= '<table border="1" cellpadding="5" style="font-family: Nunito, sans-serif; border-collapse: collapse;">
            <thead>
                <tr style="background-color: #d3d3d3; font-weight: bold;">
                 
       
                    <th>Cod Devolucion</th>
                    <th>Nombre Usuario</th>
                    <th>Fecha Devolucion</th>
                    <th>Observaciones</th>
                    
                   
                </tr>
            </thead>
            <tbody>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $row['Cod_entrega'] . '</td>';
        $html .= '<td>' . $row['Nombre_usuario'] . '</td>';
        $html .= '<td>' . $row['Fecha_entregado'] . '</td>';
        $html .= '<td>' . $row['Observaciones'] . '</td>'; 
        $html .= '</tr>';
    }
} else {
    $html .= '<tr><td colspan="9">No hay registros en la tabla historial</td></tr>';
}

$html .= '</tbody>
        </table>';

// Agregar el contenido al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar la conexión a la base de datos
$mysqli->close();

// Generar el PDF y mostrarlo en el navegador
$pdf->Output('Reporte_general_prestamos.pdf', 'I');

