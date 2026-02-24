<?php
// index.php

// 1. Activar reporte de errores TOTAL
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Iniciar sesión
session_start();

// 3. DETECTOR DE ESPACIOS EN BLANCO
if (headers_sent($file, $line)) {
    echo "<div style='background:red; color:white; padding:20px; font-size:20px; z-index:99999; position:relative;'>";
    echo "<h1>¡ERROR CRÍTICO ENCONTRADO!</h1>";
    echo "<p>La sesión está fallando porque hay espacios o texto antes de &lt;?php en el archivo:</p>";
    echo "<h3>Archivo: $file</h3>";
    echo "<h3>Línea: $line</h3>";
    echo "<p><strong>SOLUCIÓN:</strong> Ve a ese archivo y borra TODO lo que esté antes de la primera etiqueta &lt;?php.</p>";
    echo "</div>";
    exit(); // Detenemos todo para que lo arregles
}

require_once "models/model.php";
require_once "controllers/controller.php";

$mvc = new MvcController();
$mvc->handleActions();

global $mvcController;
$mvcController = $mvc;



$mvc->template();
?>