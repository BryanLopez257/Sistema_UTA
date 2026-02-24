<?php
require('fpdf/fpdf.php');
require('models/conexion.php');

// Recibimos la cédula por GET (enviada desde el botón de la tabla)
$cedulaBusqueda = isset($_GET['cedula']) ? $_GET['cedula'] : '';

// --- CLASE EXTENDIDA (Mismo estilo que el General) ---
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // 1. Título de la Institución
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(144, 27, 33); // Rojo UTA
        $this->Cell(0, 10, utf8_decode('UNIVERSIDAD TÉCNICA DE AMBATO'), 0, 1, 'C');
        
        // 2. Subtítulo del Reporte
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(100, 100, 100); // Gris
        $this->Cell(0, 5, utf8_decode('Ficha Individual de Estudiante'), 0, 1, 'C');
        $this->Ln(15); // Un poco más de espacio

        // 3. Encabezado de la Tabla
        $this->SetFillColor(144, 27, 33); // Fondo Rojo
        $this->SetTextColor(255, 255, 255); // Texto Blanco
        $this->SetDrawColor(100, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 10);

        // Anchos: Cédula(25) + Nombre(35) + Apellido(35) + Dirección(65) + Teléfono(30) = 190
        $this->Cell(25, 8, utf8_decode('CÉDULA'), 1, 0, 'C', true);
        $this->Cell(35, 8, 'NOMBRE', 1, 0, 'C', true);
        $this->Cell(35, 8, 'APELLIDO', 1, 0, 'C', true);
        $this->Cell(65, 8, utf8_decode('DIRECCIÓN'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('TELÉFONO'), 1, 1, 'C', true);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetDrawColor(200, 200, 200);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, utf8_decode('Reporte generado el: ') . date('d/m/Y H:i'), 0, 0, 'L');
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
    }
}

// --- VALIDACIÓN Y CONSULTA ---
if(empty($cedulaBusqueda)){
    die("Error: No se proporcionó un número de cédula.");
}

// Limpiar la entrada para evitar inyección SQL básica
$cedulaBusqueda = $conn->real_escape_string($cedulaBusqueda);

// Consulta filtrada por la cédula específica
$sql = "SELECT * FROM estudiantes WHERE estcedula = '$cedulaBusqueda'";
$respuesta = $conn->query($sql);

// --- GENERACIÓN DEL PDF ---
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);

// Verificar si se encontró el estudiante
if ($respuesta->num_rows > 0) {
    $fila = $respuesta->fetch_object();

    // Datos
    $cedula = $fila->estcedula;
    $nombre = utf8_decode($fila->estnombre);
    $apellido = utf8_decode($fila->estapellido);
    $direccion = utf8_decode(substr($fila->estdireccion, 0, 45)); 
    $telefono = $fila->esttelefono;

    // Pintar la fila (aunque sea solo una, usamos el estilo cebra gris claro)
    $pdf->SetFillColor(245, 245, 245); 
    
    $pdf->Cell(25, 10, $cedula, 'LRB', 0, 'C', true);
    $pdf->Cell(35, 10, $nombre, 'LRB', 0, 'L', true);
    $pdf->Cell(35, 10, $apellido, 'LRB', 0, 'L', true);
    $pdf->Cell(65, 10, $direccion, 'LRB', 0, 'L', true);
    $pdf->Cell(30, 10, $telefono, 'LRB', 1, 'C', true);

} else {
    // Si no existe el estudiante
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(190, 20, utf8_decode('No se encontró ningún estudiante con la cédula: ' . $cedulaBusqueda), 1, 1, 'C');
}

$pdf->Output();
?>