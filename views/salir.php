<?php
// views/salir.php

session_destroy(); // Destruye todas las variables de sesión

// Redirecciona al login
echo '<script>
    window.location = "index.php?action=login";
</script>';
?>