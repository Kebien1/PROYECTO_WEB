<?php
// Archivo: index.php
session_start();
?>
<!doctype html>
<html lang="es" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenido a PrograWeb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex h-100 text-center text-bg-dark align-items-center justify-content-center">
    
    <div class="cover-container p-3 w-100" style="max-width: 600px;">
        <main class="px-3">
            <div class="mb-5">
                <i class="bi bi-layers-fill text-primary" style="font-size: 5rem;"></i>
                <h1 class="display-4 fw-bold">PrograWeb</h1>
                <p class="lead">Sistema de Gestión Escolar</p>
            </div>
            
            <div class="card text-bg-light shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <div>
                                Hola, <strong><?php echo $_SESSION['usuario_nick']; ?></strong>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="modules/usuarios/index.php" class="btn btn-primary btn-lg">
                                <i class="bi bi-speedometer2 me-2"></i>Ir al Panel
                            </a>
                            <a href="modules/auth/logout.php" class="btn btn-outline-danger btn-lg">
                                Cerrar Sesión
                            </a>
                        </div>
                    <?php else: ?>
                        <p class="mb-4 text-muted">Selecciona una opción para continuar</p>
                        <div class="d-grid gap-3">
                            <a href="modules/auth/login.php" class="btn btn-primary btn-lg fw-bold">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                            </a>
                            <a href="modules/auth/register.php" class="btn btn-outline-secondary btn-lg">
                                Registrarse
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        
        <footer class="mt-5 text-white-50">
            <p>&copy; <?php echo date('Y'); ?> Proyecto Web</p>
        </footer>
    </div>

</body>
</html>