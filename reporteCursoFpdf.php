<?php
require('fpdf/fpdf.php');
require('models/conexion.php');

// 1. Recibir el ID del curso
$id_curso = isset($_GET['id_curso']) ? intval($_GET['id_curso']) : 0;

if ($id_curso == 0) {
    die("Error: No se ha seleccionado un curso.");
}

// 2. Obtener datos del Curso (Para el título del reporte)
$sqlCurso = "SELECT * FROM cursos WHERE id_cur = $id_curso";
$resCurso = $conn->query($sqlCurso);

if ($resCurso->num_rows == 0) {
    die("Error: El curso seleccionado no existe.");
}

$datosCurso = $resCurso->fetch_assoc();
$nombreCompletoCurso = $datosCurso['nom_cur'] . " - " . $datosCurso['des_cur']; // Ej: PRIMERO - ING. SISTEMAS

// --- CLASE EXTENDIDA FPDF ---
class PDF extends FPDF
{
    public $nombreCursoHeader; // Variable para pasar el nombre del curso al Header

    function Header()
    {
        // Título Institución
        $this->SetFont('Arial', 'B', 18);
        $this->SetTextColor(144, 27, 33); // Rojo UTA
        $this->Cell(0, 10, utf8_decode('UNIVERSIDAD TÉCNICA DE AMBATO'), 0, 1, 'C');
        
        // Subtítulo
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor(50, 50, 50);
        $this->Cell(0, 6, utf8_decode('NÓMINA DE ESTUDIANTES'), 0, 1, 'C');
        
        // Nombre del Curso (Dinámico)
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 6, utf8_decode('Curso: ' . $this->nombreCursoHeader), 0, 1, 'C');
        $this->Ln(10);

        // Encabezados de Tabla
        $this->SetFillColor(144, 27, 33);
        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(100, 0, 0);
        $this->SetLineWidth(.3);
        $this->SetFont('Arial', 'B', 10);

        // Anchos: Cedula(30), Nombre(40), Apellido(40), Dirección(50), Tel(30) = 190
        $this->Cell(30, 8, utf8_decode('CÉDULA'), 1, 0, 'C', true);
        $this->Cell(40, 8, 'NOMBRE', 1, 0, 'C', true);
        $this->Cell(40, 8, 'APELLIDO', 1, 0, 'C', true);
        $this->Cell(50, 8, utf8_decode('DIRECCIÓN'), 1, 0, 'C', true);
        $this->Cell(30, 8, utf8_decode('TELÉFONO'), 1, 1, 'C', true);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetDrawColor(200, 200, 200);
        $this->Line(10, $this->GetY(), 200, $this->GetY());
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb} - Generado el: ' . date('d/m/Y H:i'), 0, 0, 'C');
    }
}

// 3. Obtener Estudiantes Matriculados en ese Curso
$sqlEstudiantes = "SELECT e.estcedula, e.estnombre, e.estapellido, e.estdireccion, e.esttelefono 
                   FROM matriculas m 
                   INNER JOIN estudiantes e ON m.id_est_per = e.estcedula 
                   WHERE m.id_cur_per = $id_curso 
                   ORDER BY e.estapellido ASC";

$resEst = $conn->query($sqlEstudiantes);

// --- GENERAR PDF ---
$pdf = new PDF();
$pdf->nombreCursoHeader = $nombreCompletoCurso; // Pasamos el dato a la clase
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(0);

// Variable para alternar color de fondo (Zebra)
$fill = false;
$pdf->SetFillColor(245, 245, 245);

if ($resEst->num_rows > 0) {
    while ($fila = $resEst->fetch_assoc()) {
        $pdf->Cell(30, 7, $fila['estcedula'], 'LR', 0, 'C', $fill);
        $pdf->Cell(40, 7, utf8_decode($fila['estnombre']), 'LR', 0, 'L', $fill);
        $pdf->Cell(40, 7, utf8_decode($fila['estapellido']), 'LR', 0, 'L', $fill);
        // Recortar dirección larga
        $pdf->Cell(50, 7, utf8_decode(substr($fila['estdireccion'], 0, 30)), 'LR', 0, 'L', $fill);
        $pdf->Cell(30, 7, $fila['esttelefono'], 'LR', 1, 'C', $fill);
        
        $fill = !$fill; // Alternar color
    }
    $pdf->Cell(190, 0, '', 'T'); // Línea final
} else {
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(0, 10, utf8_decode('No hay estudiantes matriculados en este curso.'), 1, 1, 'C');
}

$pdf->Output('I', 'Reporte_Curso_' . $id_curso . '.pdf');
?>