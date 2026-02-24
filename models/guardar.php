<?php
include "conexion.php";

// Debug: Ver qué se está recibiendo
error_log("POST recibido: " . print_r($_POST, true));

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
}

if (isset($_POST['estnombre']) && $_POST['estnombre'] !== '') {
    $estnombre = mysqli_real_escape_string($conn, trim($_POST['estnombre']));
} elseif (isset($_POST['nombre']) && $_POST['nombre'] !== '') {
    $estnombre = mysqli_real_escape_string($conn, trim($_POST['nombre']));
}

if (isset($_POST['estapellido']) && $_POST['estapellido'] !== '') {
    $estapellido = mysqli_real_escape_string($conn, trim($_POST['estapellido']));
} elseif (isset($_POST['apellido']) && $_POST['apellido'] !== '') {
    $estapellido = mysqli_real_escape_string($conn, trim($_POST['apellido']));
}

if (isset($_POST['estdireccion']) && $_POST['estdireccion'] !== '') {
    $estdireccion = mysqli_real_escape_string($conn, trim($_POST['estdireccion']));
} elseif (isset($_POST['direccion']) && $_POST['direccion'] !== '') {
    $estdireccion = mysqli_real_escape_string($conn, trim($_POST['direccion']));
}

if (isset($_POST['esttelefono']) && $_POST['esttelefono'] !== '') {
    $esttelefono = mysqli_real_escape_string($conn, trim($_POST['esttelefono']));
} elseif (isset($_POST['telefono']) && $_POST['telefono'] !== '') {
    $esttelefono = mysqli_real_escape_string($conn, trim($_POST['telefono']));
}

error_log("Valores procesados - Cédula: $estcedula, Nombre: $estnombre, Apellido: $estapellido");

// Validar campos requeridos
if (empty($estcedula) || empty($estnombre) || empty($estapellido)) {
    echo "Error: Faltan campos requeridos (cédula, nombre, apellido)";
    error_log("Error: Campos vacíos - Cédula: '$estcedula', Nombre: '$estnombre', Apellido: '$estapellido'");
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

// Validar que cédula solo contenga números
if (!preg_match("/^[0-9]+$/", $estcedula)) {
    $errores[] = "La cédula solo puede contener números";
}

// Validar que cédula tenga exactamente 10 dígitos
if (strlen($estcedula) != 10) {
    $errores[] = "La cédula debe tener exactamente 10 dígitos";
}

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

// Si hay errores de formato, mostrarlos y detener la ejecución
if (!empty($errores)) {
    echo "Errores de validación: " . implode(", ", $errores);
    error_log("Errores de validación: " . implode(", ", $errores));
    $conn->close();
    exit;
}

// Verificar si la cédula ya existe en la base de datos
$sqlCheck = "SELECT estcedula FROM estudiantes WHERE estcedula = '$estcedula'";
$resultCheck = $conn->query($sqlCheck);

if ($resultCheck->num_rows > 0) {
    echo "Error: La cédula '$estcedula' ya está registrada";
    error_log("Error: Cédula duplicada - $estcedula");
    $conn->close();
    exit;
}

$sqlInsert = "INSERT INTO estudiantes (estcedula, estnombre, estapellido, estdireccion, esttelefono) 
              VALUES ('$estcedula', '$estnombre', '$estapellido', '$estdireccion', '$esttelefono')";

error_log("SQL: " . $sqlInsert);

$respuesta = $conn->query($sqlInsert);

if ($respuesta == TRUE) {
    echo "Se inserto el estudiante";
    error_log("Estudiante insertado correctamente");
} else {
    echo "No se inserto el estudiante. Error: " . $conn->error;
    error_log("Error al insertar: " . $conn->error);
}

$conn->close();
?>