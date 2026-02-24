<?php
// models/matriculas_crud.php
include "conexion.php";

$accion = $_REQUEST['accion'] ?? '';

// --- 1. LISTAR (JSON) ---
if ($accion == 'listar') {
    header('Content-Type: application/json; charset=utf-8');
    
    // Usamos JOINs para que en la tabla se vea el Nombre y no el ID
    $sql = "SELECT m.id_mat, 
                   CONCAT(c.nom_cur, ' - ', c.des_cur) as nombre_curso, 
                   CONCAT(e.estnombre, ' ', e.estapellido) as nombre_estudiante 
            FROM matriculas m 
            INNER JOIN cursos c ON m.id_cur_per = c.id_cur 
            INNER JOIN estudiantes e ON m.id_est_per = e.estcedula 
            ORDER BY m.id_mat DESC";
    
    $res = $conn->query($sql);
    $rows = array();
    
    while($r = $res->fetch_assoc()) {
        $rows[] = $r;
    }
    echo json_encode($rows);
}

// --- 2. INSCRIBIR (GUARDAR) ---
elseif ($accion == 'inscribir') {
    
    // Validar datos
    if (empty($_POST['id_cur_per']) || empty($_POST['id_est_per'])) {
        echo "Error: Datos incompletos.";
        exit;
    }

    $id_cur = intval($_POST['id_cur_per']);
    $id_est = $conn->real_escape_string($_POST['id_est_per']); 

    $sql = "INSERT INTO matriculas (id_cur_per, id_est_per) VALUES ($id_cur, '$id_est')";
    
    try {
        if($conn->query($sql)) {
            echo "Inscripción realizada con éxito";
        } else {
            // Si falla sin excepción
            echo "Error: " . $conn->error;
        }
    } catch (mysqli_sql_exception $e) {
        // AQUÍ ATRAPAMOS EL ERROR DEL TRIGGER O DE LA LLAVE PRIMARIA
        // El mensaje será texto plano, no un error fatal
        echo "Error: " . $e->getMessage();
    }
}

// --- 3. ANULAR (ELIMINAR) ---
elseif ($accion == 'eliminar') {
    $id = intval($_POST['id_mat']);
    
    $sql = "DELETE FROM matriculas WHERE id_mat=$id";
    
    if($conn->query($sql)) {
        echo "Inscripción anulada correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>