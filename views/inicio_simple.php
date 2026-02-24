<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">

            
            <h2 class="text-center mb-4">🏠 Bienvenido a la Universidad Técnica de Ambato</h2>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title text-primary">Sistema de Gestión Académica</h4>
                    <p class="card-text">
                        Bienvenido al sistema de información académica de la Universidad Técnica de Ambato.
                        Este sistema permite la gestión integral de estudiantes y información académica.
                    </p>
                </div>
            </div>
            <?php if(isset($_SESSION['validarIngreso']) && $_SESSION['validarIngreso'] == 'ok'): ?>
                <div class="card bg-light border-info shadow-sm mb-4" style="min-width: 320px;">
                    <div class="card-body py-2 px-3 d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-user-circle fa-3x text-info"></i>
                        </div>
                        
                        <div class="flex-grow-1">
                            <h6 class="card-title text-dark fw-bold mb-1">
                                <?php echo $_SESSION['nombre_real'] ?? $_SESSION['usuario']; ?>
                            </h6>
                            <div class="small text-muted" style="line-height: 1.2;">
                                <span class="badge bg-primary mb-1">
                                    <?php echo ucfirst($_SESSION['privilegio'] ?? 'Invitado'); ?>
                                </span>
                                <br>
                                <i class="fas fa-clock me-1"></i>
                                <?php 
                                    if(empty($_SESSION['ultima_conexion'])){
                                        echo "Primer ingreso";
                                    } else {
                                        echo date("d/m/Y H:i", strtotime($_SESSION['ultima_conexion']));
                                    }
                                ?>
                            </div>
                        </div>

                        <div class="ms-3 border-start ps-3">
                            <a href="index.php?action=salir" class="btn btn-outline-danger btn-sm" title="Cerrar Sesión">
                                <i class="fas fa-sign-out-alt"></i> Salir
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Gestión de Estudiantes</h5>
                            <p class="card-text">Administra la información de los estudiantes de la universidad.</p>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-graduation-cap fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Portal Académico</h5>
                            <p class="card-text">Accede a la información académica y servicios universitarios.</p>
                            <a href="index.php?action=nosotros" class="btn btn-success">
                                Conocer Más
                            </a>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>