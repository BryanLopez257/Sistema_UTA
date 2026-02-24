<?php
// models/usuarios.php

function verificarUsuario($usuario){
    
    $conn = null;

    // Conexión segura
    if(file_exists("models/conexion.php")){
        include "models/conexion.php";
    } elseif(file_exists("../models/conexion.php")){
        include "../models/conexion.php";
    } elseif(file_exists("conexion.php")){
        include "conexion.php";
    }

    if(!$conn) return false;

    $usuario = mysqli_real_escape_string($conn, $usuario);

    // Buscamos el usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    
    $resultado = mysqli_query($conn, $sql);

    if($resultado && $fila = mysqli_fetch_assoc($resultado)){
        return $fila;
    } else {
        return false;
    }
}

// Función para actualizar la fecha en tu nueva columna
function actualizarFechaLogin($idUsuario){
    global $conn;
    
    if(!$conn){
         if(file_exists("models/conexion.php")) include "models/conexion.php";
         elseif(file_exists("conexion.php")) include "conexion.php";
    }

    $fechaActual = date('Y-m-d H:i:s');
    
    // Aquí actualizamos el campo que acabamos de crear en el Paso 1
    $sql = "UPDATE usuarios SET ultima_conexion = '$fechaActual' WHERE id = '$idUsuario'";
    mysqli_query($conn, $sql);
}
?>