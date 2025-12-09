<?php
// includes/header.php
include_once(__DIR__ . "/auth.php");
?>
<!doctype html>
<html lang="es" class="h-100">
<head>
    <title>PrograWeb Sistema</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column h-100 bg-light">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="<?php echo $base_url; ?>">
                    <i class="bi bi-layers-fill text-warning me-2"></i>PrograWeb
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>modules/usuarios/">Usuarios</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>modules/roles/">Roles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $base_url; ?>modules/permisos/">Permisos</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> <?php echo $_SESSION['usuario_nick']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item text-danger" href="<?php echo $base_url; ?>logout.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <main class="flex-shrink-0">
        <div class="container py-4">