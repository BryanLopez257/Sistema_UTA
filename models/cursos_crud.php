<?php
// models/cursos_crud.php
include "conexion.php";

$accion = $_REQUEST['accion'] ?? '';

// --- 1. LISTAR (JSON para las tablas) ---
if ($accion == 'listar') {
    header('Content-Type: application/json; charset=utf-8');
    
    $sql = "SELECT * FROM cursos ORDER BY nom_cur";
    $res = $conn->query($sql);
    $rows = array();
    
    while($r = $res->fetch_assoc()) {
        $rows[] = $r;
    }
    // EasyUI y tu JS de Bootstrap consumen este array directamente
    echo json_encode($rows);
}

// 2. GUARDAR
elseif ($accion == 'guardar') {
    $nombre = strtoupper($conn->real_escape_string($_POST['nom_cur']));
    $desc = strtoupper($conn->real_escape_string($_POST['des_cur']));
    $titulo = strtoupper($conn->real_escape_string($_POST['tit_oto']));

    $sql = "INSERT INTO cursos (nom_cur, des_cur, tit_oto) VALUES ('$nombre', '$desc', '$titulo')";
    
    try {
        if($conn->query($sql)) {
            echo "Curso guardado correctamente";
        } else {
            // Si falla sin lanzar excepción
            echo "Error: " . $conn->error;
        }
    } catch (mysqli_sql_exception $e) {
        // AQUÍ ATRAPAMOS EL ERROR (Sea del Trigger o de la Llave Primaria)
        // Y mostramos el mensaje limpio sin romper la página
        echo "Error: " . $e->getMessage();
    }
}

// --- 3. EDITAR ---
elseif ($accion == 'editar') {
    $id = intval($_POST['id_cur']);
    $nom = strtoupper($conn->real_escape_string($_POST['nom_cur']));
    $des = strtoupper($conn->real_escape_string($_POST['des_cur']));
    $tit = strtoupper($conn->real_escape_string($_POST['tit_oto']));

    $sql = "UPDATE cursos SET nom_cur='$nom', des_cur='$des', tit_oto='$tit' WHERE id_cur=$id";
    
    if($conn->query($sql)) {
        echo "Curso actualizado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}

// --- 4. ELIMINAR ---
elseif ($accion == 'eliminar') {
    $id = intval($_POST['id_cur']);
    
    $sql = "DELETE FROM cursos WHERE id_cur=$id";
    
    if($conn->query($sql)) {
        echo "Curso eliminado correctamente";
    } else {
        // El trigger EVITAR_BORRAR_CURSO_CON_ALUMNOS saltará aquí
        echo "Error: " . $conn->error;
    }
}
?>