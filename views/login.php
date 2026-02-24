<style>
    /* Estilos específicos para el login dentro del template */
    .login-page-container {
        background: linear-gradient(135deg, var(--uta-primary, #901B21) 0%, var(--uta-primary-dark, #7A1619) 50%, var(--uta-accent, #2C3E50) 100%);
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: -20px;
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    .login-page-container::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 100%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,215,0,0.1)"/></svg>') repeat;
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-20px) rotate(180deg);
        }
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        overflow: hidden;
        transition: all 0.3s ease;
        max-width: 450px;
        width: 100%;
        position: relative;
        z-index: 10;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .login-header {
        background: linear-gradient(135deg, var(--uta-primary, #901B21) 0%, var(--uta-primary-dark, #7A1619) 50%, var(--uta-accent, #2C3E50) 100%);
        color: white;
        padding: 2.5rem 2rem;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><polygon points="0,100 100,0 100,100" fill="rgba(255,215,0,0.05)"/></svg>');
    }

    .login-header .university-icon {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        animation: pulse 2s ease-in-out infinite;
        position: relative;
        z-index: 1;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .login-header h3 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .login-header p {
        font-weight: 300;
        opacity: 0.9;
        font-size: 0.95rem;
        position: relative;
        z-index: 1;
        margin: 0;
    }

    .login-card .card-body {
        padding: 2.5rem;
    }

    .login-card .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .login-card .form-control {
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(248, 249, 250, 0.8);
    }

    .login-card .form-control:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.15);
        background: white;
        transform: translateY(-1px);
    }

    .login-card .btn-primary {
        background: linear-gradient(135deg, var(--uta-primary, #901B21), var(--uta-primary-dark, #7A1619));
        border: none;
        border-radius: 12px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(144, 27, 33, 0.3);
        width: 100%;
    }

    .login-card .btn-primary:hover {
        background: linear-gradient(135deg, var(--uta-primary-light, #A52A31), var(--uta-primary, #901B21));
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(144, 27, 33, 0.4);
    }

    .login-card .btn-outline-secondary {
        border: 2px solid #6c757d;
        border-radius: 12px;
        padding: 0.6rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .login-card .btn-outline-secondary:hover {
        background: #6c757d;
        transform: translateY(-1px);
    }

    .login-card .alert-danger {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 500;
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
    }

    .credentials-info {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid #dee2e6;
    }

    .credentials-info strong {
        color: #2c3e50;
    }

    .credential-item {
        background: white;
        padding: 0.8rem;
        border-radius: 8px;
        margin: 0.5rem 0;
        border-left: 4px solid #3498db;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
    }

    .divider {
        margin: 2rem 0;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, #dee2e6, transparent);
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .login-page-container {
            margin: -10px;
            padding: 20px 10px;
            min-height: 60vh;
        }

        .login-header {
            padding: 2rem 1.5rem;
        }

        .login-card .card-body {
            padding: 2rem;
        }

        .login-header h3 {
            font-size: 1.3rem;
        }

        .login-header .university-icon {
            font-size: 3rem;
        }
    }

    @media (max-width: 480px) {
        .login-page-container {
            margin: -5px;
            padding: 15px 5px;
        }

        .login-card .card-body {
            padding: 1.5rem;
        }


    }
</style>

<div class="login-page-container">
    <div class="login-card fade-in">
        
        <div class="login-header">
            <i class="fas fa-university fa-3x mb-3" style="color: #FFD700; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"></i>
            <h3>Universidad Técnica de Ambato</h3>
            <p>Sistema de Gestión Académica</p>
        </div>

        <div class="card-body">
            
            <form method="post">
                
                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">
                        <i class="fas fa-user me-2 text-primary"></i>Usuario
                    </label>
                    <input type="text" class="form-control" name="usuarioIngreso" placeholder="Ingrese su usuario" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold text-secondary">
                        <i class="fas fa-lock me-2 text-primary"></i>Contraseña
                    </label>
                    <input type="password" class="form-control" name="passwordIngreso" placeholder="Ingrese su contraseña" required>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                    </button>
                </div>

            </form>

            <div class="divider"></div>
            <div class="text-center mt-3">
                <a href="index.php?action=inicio" class="text-decoration-none small text-muted hover-link">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </div>
</div>

<?php
// Instanciamos el controlador para que escuche el envío del formulario
$ingreso = new MvcController();
$ingreso -> loginUsuarioController();
?>

<script>
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.transition = 'transform 0.2s ease';
        });
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
</script>
