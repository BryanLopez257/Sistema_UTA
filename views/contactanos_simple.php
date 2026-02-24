<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h2 class="text-center mb-4">📞 Contáctanos</h2>

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
                        <div class="card-body">
                            <h5 class="card-title text-primary">
                                <i class="fas fa-map-marker-alt me-2"></i>Ubicación
                            </h5>
                            <p class="card-text">
                                <strong>Dirección:</strong><br>
                                Av. Los Chasquis y Río Payamino<br>
                                Huachi Chico, Ambato - Ecuador
                            </p>
                            <p class="card-text">
                                <strong>Código Postal:</strong> 180206
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title text-success">
                                <i class="fas fa-phone me-2"></i>Contacto
                            </h5>
                            <p class="card-text">
                                <strong>Teléfono:</strong><br>
                                (03) 2848487 - 2400087
                            </p>
                            <p class="card-text">
                                <strong>Email:</strong><br>
                                info@uta.edu.ec<br>
                                admisiones@uta.edu.ec
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title text-warning">
                        <i class="fas fa-clock me-2"></i>Horarios de Atención
                    </h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Lunes a Viernes:</strong></p>
                            <ul class="list-unstyled">
                                <li>Mañana: 08:00 - 12:00</li>
                                <li>Tarde: 14:00 - 18:00</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sábados:</strong></p>
                            <ul class="list-unstyled">
                                <li>Mañana: 08:00 - 12:00</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>