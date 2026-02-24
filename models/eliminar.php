<?php
include "conexion.php";

// Debug
error_log("POST recibido en eliminar: " . print_r($_POST, true));

// Aceptar tanto 'estcedula' como 'cedula'
$estcedula = '';
if (isset($_POST['estcedula']) && !empty($_POST['estcedula'])) {
    $estcedula = mysqli_real_escape_string($conn, trim($_POST['estcedula']));
} elseif (isset($_POST['cedula']) && !empty($_POST['cedula'])) {
    $estcedula = mysqli_real_escape_string($conn, trim($_POST['cedula']));
}

error_log("Cédula a eliminar: '$estcedula'");

if (empty($estcedula)) {
    echo "Error: Cédula no proporcionada.";
    error_log("Error: Cédula vacía en eliminar");
    $conn->close();
    exit;
}

$sqlBorrar = "DELETE FROM estudiantes WHERE estcedula = ?";

$stmt = $conn->prepare($sqlBorrar);
if (!$stmt) {
    echo "Error en la preparación: " . $conn->error;
    error_log("Error prepare: " . $conn->error);
    $conn->close();
    exit;
}

$stmt->bind_param("s", $estcedula);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Se elimino el estudiante";
        error_log("Estudiante eliminado correctamente - Cédula: $estcedula");
    } else {
        echo "Error: La cédula '$estcedula' no fue encontrada en la base de datos.";
        error_log("Cédula no encontrada: $estcedula");
    }
} else {
    echo "Error al ejecutar la eliminación: " . $stmt->error;
    error_log("Error en ejecución: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>