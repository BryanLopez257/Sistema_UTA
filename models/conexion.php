<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "utacuarto1"; // <--- Asegúrate que este sea el nombre exacto en tu phpMyAdmin

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Error de conexion: " . mysqli_connect_error());
}

// Forzar caracteres UTF-8 para evitar problemas con tildes/eñes
mysqli_set_charset($conn, "utf8");
?>