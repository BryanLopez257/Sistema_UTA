<?php
require('fpdf/fpdf.php');
require('models/conexion.php');

// --- CLASE EXTENDIDA PARA DISEÑO PROFESIONAL ---
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // 1. Logo (Asegúrate de tener un archivo 'logo.png' o ajusta la ruta)
        // Si no tienes logo, comenta la siguiente línea
        // $this->Image('img/escudo-uta.png', 10, 8, 20); 

        // 2. Título de la Institución
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(144, 27, 33); // Color Rojo UTA (#901B21)
        $this->Cell(0, 10, utf8_decode('UNIVERSIDAD TÉCNICA DE AMBATO'), 0, 1, 'C');
        
        // 3. Subtítulo del Reporte
        $this->SetFont('Arial', '', 12);
        $this->SetTextColor(100, 100, 100); // Gris oscuro
        $this->Cell(0, 5, utf8_decode('Reporte General de Estudiantes'), 0, 1, 'C');
        $this->Ln(10);

        // 4. Encabezado de la Tabla
        $this->SetFillColor(144, 27, 33); // Fondo Rojo UTA
        $this->SetTextColor(255, 255, 255); // Texto Blanco
        $this->SetDrawColor(100, 0, 0); // Borde rojo oscuro
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 10);

        // Anchos de columnas (Total = 190mm para A4 vertical)
        // Cédula(25) + Nombre(35) + Apellido(35) + Dirección(65) + Teléfono(30) = 190
        $this->Cell(25, 8, utf8_decode('CÉDULA'), 1, 0, 'C', true);
        $this->Cell(35, 8, 'NOMBRE', 1, 0, 'C', true);
        $this->Cell(35, 8, 'APELLIDO', 1, 0, 'C', true);
        $this->Cell(65, 8, utf8_decode('DIRECCIÓN'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('TELÉFONO'), 1, 1, 'C', true);
    }

    // Pie de página
    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        
        // Línea decorativa gris
        $this->SetDrawColor(200, 200, 200);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
        
        // Fecha de generación a la derecha
        $this->SetX(-50);
        $this->Cell(40, 10, date('d/m/Y H:i'), 0, 0, 'R');
    }
}

// --- CONSULTA DE DATOS ---
$sql = "SELECT * FROM estudiantes ORDER BY estapellido ASC"; // Ordenado por apellido se ve mejor
$respuesta = $conn->query($sql);

// --- GENERACIÓN DEL PDF ---
$pdf = new PDF();
$pdf->AliasNbPages(); // Para el total de páginas {nb}
$pdf->AddPage(); // Vertical por defecto
$pdf->SetFont('Arial', '', 9); // Fuente para los datos

// Colores para las filas alternadas (Efecto Zebra)
$fill = false; 
$pdf->SetFillColor(240, 240, 240); // Gris muy clarito
$pdf->SetTextColor(0); // Negro

while ($fila = $respuesta->fetch_object()) {
    // Datos
    $cedula = $fila->estcedula;
    $nombre = utf8_decode($fila->estnombre);
    $apellido = utf8_decode($fila->estapellido);
    // Recortar dirección si es muy larga para que no rompa la celda
    $direccion = utf8_decode(substr($fila->estdireccion, 0, 45)); 
    $telefono = $fila->esttelefono;

    // Celdas
    // El último parámetro 'LR' dibuja bordes izquierda y derecha, pero no arriba/abajo (más limpio)
    // El parámetro final $fill indica si se pinta el fondo o no
    $pdf->Cell(25, 7, $cedula, 'LR', 0, 'C', $fill);
    $pdf->Cell(35, 7, $nombre, 'LR', 0, 'L', $fill);
    $pdf->Cell(35, 7, $apellido, 'LR', 0, 'L', $fill);
    $pdf->Cell(65, 7, $direccion, 'LR', 0, 'L', $fill);
    $pdf->Cell(30, 7, $telefono, 'LR', 1, 'C', $fill);

    // Alternar color
    $fill = !$fill;
}

// Línea final para cerrar la tabla
$pdf->Cell(190, 0, '', 'T'); 

$pdf->Output();
?>