<?php
class EnlacesPaginas
{
    public function EnlacesPaginasModel($enlacesModel)
    {
        // 1. Caso SERVICIOS (PROTEGIDO)
        if ($enlacesModel == "servicios") {
            // Verificamos si la variable de sesión existe y es correcta
            if(isset($_SESSION["validarIngreso"]) && $_SESSION["validarIngreso"] == "ok"){
                $module = "views/servicios_simple.php";
            } else {
                $module = "views/login.php"; // Si no hay sesión, manda al login
            }
        } 
        // 2. Caso LOGIN
        else if ($enlacesModel == "login") {
            $module = "views/login.php";
        }
        // 3. Caso SALIR
        else if ($enlacesModel == "salir") {
            $module = "views/salir.php";
        }
        // 4. Páginas Públicas
        else if ($enlacesModel == "nosotros" || 
                 $enlacesModel == "contactanos" || 
                 $enlacesModel == "inicio") {
            
            $module = "views/" . $enlacesModel . "_simple.php";
        
        } 
        // 5. Default
        else {
            $module = "views/inicio_simple.php";
        }

        return $module;
    }
}
?>