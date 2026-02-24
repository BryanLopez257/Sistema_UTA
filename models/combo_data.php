<?php
// models/combo_data.php
include "conexion.php";

// Encabezado JSON para que JS no se confunda
header('Content-Type: application/json; charset=utf-8');

$tipo = $_REQUEST['tipo'] ?? '';
$data = array();

// Lógica para llenar los combos
if ($tipo == 'estudiantes') {
    // Concatenamos nombre para que se vea bonito en el select
    $sql = "SELECT estcedula as id, CONCAT(estcedula, ' - ', estnombre, ' ', estapellido) as text 
            FROM estudiantes ORDER BY estapellido";
} elseif ($tipo == 'cursos') {
    $sql = "SELECT id_cur as id, CONCAT(nom_cur, ' - ', des_cur) as text 
            FROM cursos ORDER BY nom_cur";
} else {
    echo json_encode([]);
    exit;
}

$res = $conn->query($sql);

if($res){
    while($row = $res->fetch_assoc()) {
        // Aseguramos UTF-8 por si hay tildes
        $data[] = array_map('utf8_encode', $row); 
        // Si ya usas UTF-8 en la conexión, puedes usar $row directo: $data[] = $row;
    }
}

echo json_encode($data);
?>