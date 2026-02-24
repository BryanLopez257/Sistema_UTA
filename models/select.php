<?php
// models/select.php

// Iniciar sesión si no está iniciada (para validar roles más abajo)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lógica inteligente para encontrar la conexión
if (file_exists("models/conexion.php")) {
    include "models/conexion.php"; 
} elseif (file_exists("../models/conexion.php")) { // <--- Agregamos este por si acaso
    include "../models/conexion.php"; 
} elseif (file_exists("conexion.php")) {
    include "conexion.php"; 
} else {
    die("Error crítico: No se encuentra models/conexion.php");
}

// ... resto del código ...

// Consulta base
$sql = "select estcedula, estnombre, estapellido, estdireccion, esttelefono from estudiantes";

// Aplicar filtro por cédula si se proporciona
$where = '';
$ced = '';

if (isset($_REQUEST['cedula']) && $_REQUEST['cedula'] !== '') {
    $ced = $conn->real_escape_string(trim($_REQUEST['cedula']));
} elseif (isset($_REQUEST['q']) && $_REQUEST['q'] !== '') {
    $ced = $conn->real_escape_string(trim($_REQUEST['q']));
}

if ($ced !== '') {
    $where = " WHERE estcedula LIKE '%" . $ced . "%'";
}

$sql .= $where;


// ... (Toda la parte de conexión y consulta SQL se mantiene igual arriba) ...

// Asegurarnos de tener acceso a la sesión (para peticiones AJAX)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Ejecutar consulta (código existente)
$respuesta = $conn->query($sql);

// --- SALIDA HTML MODIFICADA CON ROLES ---
if (isset($_GET['formato']) && $_GET['formato'] == 'html') {
    if ($respuesta && $respuesta->num_rows > 0) {
        while ($fila = $respuesta->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($fila['estcedula']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['estnombre']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['estapellido']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['estdireccion']) . "</td>";
            echo "<td>" . htmlspecialchars($fila['esttelefono']) . "</td>";
            
            // --- VALIDACIÓN DE ROL AQUÍ ---
            echo "<td>"; 
            
            // Solo mostramos botones si el rol es SECRETARIA
            if(isset($_SESSION['privilegio']) && strtolower($_SESSION['privilegio']) == 'secretaria'){
                echo "<button class='btn btn-warning btn-sm me-2 edit-btn' data-estcedula='" . htmlspecialchars($fila['estcedula']) . "'><i class='fas fa-edit'></i> Editar</button>";
                echo "<button class='btn btn-danger btn-sm delete-btn' data-estcedula='" . htmlspecialchars($fila['estcedula']) . "'><i class='fas fa-trash-alt'></i> Eliminar</button>";
            } else {
                echo "<span class='badge bg-secondary'><i class='fas fa-eye'></i> Solo Lectura</span>";
            }
            
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='text-center text-muted'>No hay estudiantes para mostrar.</td></tr>"; 
    }
} 

// 2. Si es para AJAX/EasyUI (Formato JSON)
else {
    header('Content-Type: application/json');
    
    $rows = array();
    if ($respuesta && $respuesta->num_rows > 0) {
        while ($fila = $respuesta->fetch_assoc()) {
            $rows[] = $fila;
        }
    }
    echo json_encode(array('total' => count($rows), 'rows' => $rows));
}
?>