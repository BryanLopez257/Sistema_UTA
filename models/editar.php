<?php
include "conexion.php";

// Aceptar nombres de campos con o sin prefijo 'est'
$estcedula = '';
$estnombre = '';
$estapellido = '';
$estdireccion = '';
$esttelefono = '';

if (isset($_POST['estcedula']) && !empty($_POST['estcedula'])) {
    $estcedula = mysqli_real_escape_string($conn, trim($_POST['estcedula']));
} elseif (isset($_POST['cedula']) && !empty($_POST['cedula'])) {
    $estcedula = mysqli_real_escape_string($conn, trim($_POST['cedula']));
} elseif (isset($_POST['editCedulaOriginal']) && !empty($_POST['editCedulaOriginal'])) {
    // fallback from some views
    $estcedula = mysqli_real_escape_string($conn, trim($_POST['editCedulaOriginal']));
}

if (isset($_POST['estnombre']) && $_POST['estnombre'] !== '') {
    $estnombre = mysqli_real_escape_string($conn, trim($_POST['estnombre']));
} elseif (isset($_POST['nombre']) && $_POST['nombre'] !== '') {
    $estnombre = mysqli_real_escape_string($conn, trim($_POST['nombre']));
} elseif (isset($_POST['editNombre']) && $_POST['editNombre'] !== '') {
    $estnombre = mysqli_real_escape_string($conn, trim($_POST['editNombre']));
}

if (isset($_POST['estapellido']) && $_POST['estapellido'] !== '') {
    $estapellido = mysqli_real_escape_string($conn, trim($_POST['estapellido']));
} elseif (isset($_POST['apellido']) && $_POST['apellido'] !== '') {
    $estapellido = mysqli_real_escape_string($conn, trim($_POST['apellido']));
} elseif (isset($_POST['editApellido']) && $_POST['editApellido'] !== '') {
    $estapellido = mysqli_real_escape_string($conn, trim($_POST['editApellido']));
}

if (isset($_POST['estdireccion']) && $_POST['estdireccion'] !== '') {
    $estdireccion = mysqli_real_escape_string($conn, trim($_POST['estdireccion']));
} elseif (isset($_POST['direccion']) && $_POST['direccion'] !== '') {
    $estdireccion = mysqli_real_escape_string($conn, trim($_POST['direccion']));
} elseif (isset($_POST['editDireccion']) && $_POST['editDireccion'] !== '') {
    $estdireccion = mysqli_real_escape_string($conn, trim($_POST['editDireccion']));
}

if (isset($_POST['esttelefono']) && $_POST['esttelefono'] !== '') {
    $esttelefono = mysqli_real_escape_string($conn, trim($_POST['esttelefono']));
} elseif (isset($_POST['telefono']) && $_POST['telefono'] !== '') {
    $esttelefono = mysqli_real_escape_string($conn, trim($_POST['telefono']));
} elseif (isset($_POST['editTelefono']) && $_POST['editTelefono'] !== '') {
    $esttelefono = mysqli_real_escape_string($conn, trim($_POST['editTelefono']));
}

// Validar campos requeridos
if (empty($estcedula) || empty($estnombre) || empty($estapellido)) {
    echo "Error: Faltan campos requeridos (cédula, nombre, apellido)";
    $conn->close();
    exit;
}

// Valores por defecto si están vacíos
if (empty($esttelefono)) {
    $esttelefono = "0900000000";
}

if (empty($estdireccion)) {
    $estdireccion = "S/A";
}

// VALIDACIONES DE FORMATO
$errores = [];

// Validar que nombre solo contenga letras y espacios
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $estnombre)) {
    $errores[] = "El nombre solo puede contener letras";
}

// Validar que apellido solo contenga letras y espacios
if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $estapellido)) {
    $errores[] = "El apellido solo puede contener letras";
}

// Validar que teléfono solo contenga números
if (!preg_match("/^[0-9]+$/", $esttelefono)) {
    $errores[] = "El teléfono solo puede contener números";
}

// Validar que teléfono tenga exactamente 10 dígitos
if (strlen($esttelefono) != 10) {
    $errores[] = "El teléfono debe tener exactamente 10 dígitos";
}

// Validar que teléfono comience con 09
if (!preg_match("/^09/", $esttelefono)) {
    $errores[] = "El teléfono debe comenzar con 09";
}

// Si hay errores, mostrarlos y detener la ejecución
if (!empty($errores)) {
    echo "Errores de validación: " . implode(", ", $errores);
    $conn->close();
    exit;
}

$sqlUpdate = "UPDATE estudiantes SET 
              estnombre = '$estnombre', 
              estapellido = '$estapellido', 
              estdireccion = '$estdireccion', 
              esttelefono = '$esttelefono' 
              WHERE estcedula = '$estcedula'";

$respuesta = $conn->query($sqlUpdate);

if ($respuesta == TRUE) {
    echo "Se actualizo el estudiante";
} else {
    echo "No se actualizo el estudiante. Error: " . $conn->error;
}

$conn->close();
?>