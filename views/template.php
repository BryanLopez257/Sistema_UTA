<!DOCTYPE html>
<html lang="es" translate="no">
<head>
    <meta charset="UTF-8">
    <title>UTA - Gestión Académica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/uta-theme.css">
    <link rel="stylesheet" href="css/banner-png.css">

    <style>
        body { min-height: 100vh; display: flex; flex-direction: column; }
        .banner-container {
            width: 100%; height: 120px;
            background: linear-gradient(135deg, #901B21 0%, #B22429 50%, #701418 100%);
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .banner-img { max-height: 150px; width: 100%; object-fit: cover; }
        .container-fluid { flex: 1; }
        
        /* Ajuste para el dropdown de usuario */
        .navbar-nav .dropdown-menu {
            position: absolute;
            right: 0;
            left: auto;
        }
    </style>
</head>
<body>

    <header class="banner-container">
        <img src="https://res.cloudinary.com/dwwvecqnu/image/upload/f_auto,q_auto/srjxoupeycmg9yaanbz3" class="banner-img" alt="UTA">
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?action=inicio"><i class="fas fa-home"></i> Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=nosotros"><i class="fas fa-users"></i> Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=servicios"><i class="fas fa-cogs"></i> Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php?action=contactanos"><i class="fas fa-envelope"></i> Contáctanos</a></li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION["validarIngreso"]) && $_SESSION["validarIngreso"] == "ok"): ?>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #FFD700;">
                                <i class="fas fa-user-circle"></i> 
                                <?php echo $_SESSION["nombre_real"] ?? $_SESSION["usuario"]; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <span class="dropdown-item-text small text-muted">
                                        Rol: <?php echo ucfirst($_SESSION["privilegio"] ?? ''); ?>
                                    </span>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="index.php?action=salir">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>

                    <?php else: ?>
                        
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light border-0 ms-2" href="index.php?action=login">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </a>
                        </li>

                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </nav>

    <section>
        <?php
        global $mvcController;
        if (isset($mvcController)) {
            $mvcController->EnlacesPaginasController();
        }
        ?>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>