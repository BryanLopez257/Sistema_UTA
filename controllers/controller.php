<?php

class MvcController
{
    private $enlacesController = "inicio"; // Por defecto inicio

    // Maneja la navegación (Recibe la variable $_GET)
    public function handleActions()
    {
        if (isset($_GET['action'])) {
            $this->enlacesController = $_GET['action'];
        } else {
            $this->enlacesController = "inicio";
        }
    }

    // Carga la plantilla principal
    public function template()
    {
        include "views/template.php";
    }

    // Carga el contenido dinámico (centro de la página)
    public function EnlacesPaginasController()
    {
        // Verificamos que el archivo modelo exista antes de llamarlo
        if(file_exists("models/model.php")){
            require_once "models/model.php";
        } else {
            echo "Error: Falta models/model.php";
            return;
        }
        
        $enlacesPagina = new EnlacesPaginas();
        $respuesta = $enlacesPagina->EnlacesPaginasModel($this->enlacesController);

        if (file_exists($respuesta)) {
            include $respuesta;
        } else {
            // Si el archivo no existe (ej. views/algo.php), forzamos el inicio
            include "views/inicio_simple.php";
        }
    }

    public function loginUsuarioController(){
        if(isset($_POST["usuarioIngreso"])){
            
            require_once "models/usuarios.php";

            $usuario = $_POST["usuarioIngreso"];
            $password = $_POST["passwordIngreso"];

            $respuesta = verificarUsuario($usuario);

            if($respuesta){
                
                // Verificamos estado ACTIVO
                if($respuesta['estado'] != 'activo'){
                    echo '<div class="alert alert-warning mt-3 text-center">Usuario inactivo</div>';
                    return;
                }

                // Verificamos contraseña (MD5 según tu tabla)
                if($respuesta["password"] == md5($password) || $respuesta["password"] == $password){

                    // --- MAPEO EXACTO DE TU TABLA A LA SESIÓN ---
                    
                    $_SESSION["validarIngreso"] = "ok";
                    $_SESSION["id"] = $respuesta["id"];
                    $_SESSION["usuario"] = $respuesta["usuario"]; 
                    
                    // 1. NOMBRE COMPLETO (De tu campo nombre_completo)
                    $_SESSION["nombre_real"] = $respuesta["nombre_completo"]; 
                    
                    // 2. TIPO DE USUARIO (De tu campo tipo_usuario: 'administrador' o 'secretaria')
                    $_SESSION["privilegio"] = $respuesta["tipo_usuario"]; 

                    // 3. ÚLTIMA CONEXIÓN
                    $_SESSION["ultima_conexion"] = $respuesta["ultima_conexion"];

                    // 4. Actualizar fecha en BD
                    actualizarFechaLogin($respuesta["id"]);

                    // --- FIN ---

                    session_write_close(); 

                    echo '<script>
                        window.location = "index.php?action=servicios";
                    </script>';
                    exit(); 

                } else {
                    echo '<div class="alert alert-danger mt-3 text-center">Contraseña incorrecta</div>';
                }

            } else {
                echo '<div class="alert alert-danger mt-3 text-center">Usuario no encontrado</div>';
            }
        }
    }
}
?>