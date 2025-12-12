<?php
// Archivo: index.php
session_start();
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PrograWeb Academy - Cursos Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary fs-4" href="#">
                <i class="bi bi-mortarboard-fill me-2"></i>PrograWeb
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#caracteristicas">Características</a></li>
                    <li class="nav-item"><a class="nav-link" href="#cursos">Cursos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#opiniones">Opiniones</a></li>
                </ul>

                <div class="d-flex gap-2">
                    <?php if(isset($_SESSION['usuario_id'])): ?>
                        <div class="dropdown">
                            <a href="#" class="btn btn-outline-primary dropdown-toggle fw-bold" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> <?php echo $_SESSION['usuario_nick']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                <li><a class="dropdown-item" href="modules/usuarios/index.php">Mi Panel</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="modules/auth/logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="modules/auth/login.php" class="btn btn-outline-primary fw-bold px-3">Ingresar</a>
                        <a href="modules/auth/register.php" class="btn btn-primary fw-bold px-3">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <header id="inicio" class="bg-white py-5 border-bottom">
        <div class="container py-5">
            <div class="row align-items-center flex-lg-row-reverse g-5">
                <div class="col-10 col-sm-8 col-lg-6 text-center">
                    <i class="bi bi-laptop text-primary opacity-25" style="font-size: 10rem;"></i>
                </div>
                <div class="col-lg-6">
                    <div class="badge bg-primary bg-opacity-10 text-primary mb-3 px-3 py-2 rounded-pill">
                        🎓 Nueva Plataforma Educativa
                    </div>
                    <h1 class="display-4 fw-bold lh-1 mb-3 text-dark">Lleva tu aprendizaje al siguiente nivel</h1>
                    <p class="lead text-muted mb-4">
                        Accede a cursos de alta calidad, gestiona tus materias y obtén certificaciones válidas. Todo en una plataforma rápida y segura.
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <?php if(!isset($_SESSION['usuario_id'])): ?>
                            <a href="modules/auth/register.php" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold shadow-sm">Comenzar Gratis</a>
                            <a href="modules/auth/login.php" class="btn btn-outline-secondary btn-lg px-4">Ver Demo</a>
                        <?php else: ?>
                            <a href="modules/usuarios/index.php" class="btn btn-success btn-lg px-5 fw-bold shadow-sm">
                                <i class="bi bi-speedometer2 me-2"></i>Ir a mi Escritorio
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="bg-primary text-white py-4">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-3">
                    <h2 class="fw-bold display-6 mb-0">+500</h2>
                    <span class="opacity-75">Estudiantes Activos</span>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold display-6 mb-0">50</h2>
                    <span class="opacity-75">Cursos Disponibles</span>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold display-6 mb-0">24/7</h2>
                    <span class="opacity-75">Soporte Técnico</span>
                </div>
                <div class="col-md-3">
                    <h2 class="fw-bold display-6 mb-0">100%</h2>
                    <span class="opacity-75">Satisfacción</span>
                </div>
            </div>
        </div>
    </section>

    <section id="caracteristicas" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">¿Por qué elegirnos?</h2>
                <p class="text-muted">Herramientas diseñadas para potenciar tu educación.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="text-primary mb-3"><i class="bi bi-clock-history fs-1"></i></div>
                        <h4 class="fw-bold">A tu ritmo</h4>
                        <p class="text-muted small">Estudia cuando quieras y donde quieras. Sin horarios fijos ni presiones.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="text-success mb-3"><i class="bi bi-patch-check-fill fs-1"></i></div>
                        <h4 class="fw-bold">Certificados</h4>
                        <p class="text-muted small">Al finalizar cada módulo, recibe un certificado digital verificable.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="text-warning mb-3"><i class="bi bi-people-fill fs-1"></i></div>
                        <h4 class="fw-bold">Comunidad</h4>
                        <p class="text-muted small">Interactúa con otros estudiantes y profesores en nuestros foros.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="cursos" class="py-5 bg-white">
        <div class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Cursos Destacados</h2>
                <a href="#" class="btn btn-outline-primary btn-sm">Ver todos</a>
            </div>
            
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col">
                    <div class="card h-100 shadow-sm border rounded-3 overflow-hidden">
                        <div class="bg-dark text-white p-5 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-filetype-php display-1 text-warning"></i>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-warning text-dark mb-2">Programación</span>
                            <h5 class="card-title fw-bold">Master en PHP y MySQL</h5>
                            <p class="card-text text-muted small">Aprende a crear sistemas web dinámicos desde cero hasta avanzado.</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> 20 Horas</small>
                            <button class="btn btn-sm btn-primary">Ver temario</button>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card h-100 shadow-sm border rounded-3 overflow-hidden">
                        <div class="bg-dark text-white p-5 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-bootstrap display-1 text-info"></i>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-info text-dark mb-2">Diseño Web</span>
                            <h5 class="card-title fw-bold">Bootstrap 5 Avanzado</h5>
                            <p class="card-text text-muted small">Diseña sitios web responsivos y modernos sin escribir CSS puro.</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> 15 Horas</small>
                            <button class="btn btn-sm btn-primary">Ver temario</button>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 shadow-sm border rounded-3 overflow-hidden">
                        <div class="bg-dark text-white p-5 text-center d-flex align-items-center justify-content-center">
                            <i class="bi bi-database-fill-gear display-1 text-danger"></i>
                        </div>
                        <div class="card-body">
                            <span class="badge bg-danger text-white mb-2">Backend</span>
                            <h5 class="card-title fw-bold">Gestión de Bases de Datos</h5>
                            <p class="card-text text-muted small">Optimización, consultas complejas y seguridad en SQL.</p>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center pb-3">
                            <small class="text-muted"><i class="bi bi-clock me-1"></i> 30 Horas</small>
                            <button class="btn btn-sm btn-primary">Ver temario</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="opiniones" class="py-5 bg-light">
        <div class="container py-5">
            <h2 class="fw-bold text-center mb-5">Lo que dicen nuestros alumnos</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-2 me-3 fs-4 fw-bold" style="width: 50px; height: 50px; text-align: center;">JD</div>
                            <div>
                                <h6 class="fw-bold mb-0">Juan Diaz</h6>
                                <small class="text-warning">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </small>
                            </div>
                        </div>
                        <p class="text-muted fst-italic">"Excelente plataforma. Pude aprender PHP en muy poco tiempo y conseguir mi primer empleo como desarrollador."</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle p-2 me-3 fs-4 fw-bold" style="width: 50px; height: 50px; text-align: center;">MP</div>
                            <div>
                                <h6 class="fw-bold mb-0">Maria Perez</h6>
                                <small class="text-warning">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
                                </small>
                            </div>
                        </div>
                        <p class="text-muted fst-italic">"Me encanta que sea tan fácil de usar. Puedo ver mis notas y descargar materiales desde mi celular sin problemas."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">PrograWeb</h5>
                    <p class="small">Plataforma líder en educación tecnológica online. Formando a los profesionales del futuro.</p>
                </div>
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 fw-bold">Enlaces</h6>
                    <p><a href="#" class="text-white text-decoration-none small">Inicio</a></p>
                    <p><a href="#" class="text-white text-decoration-none small">Cursos</a></p>
                    <p><a href="#" class="text-white text-decoration-none small">Precios</a></p>
                </div>
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 fw-bold">Soporte</h6>
                    <p><a href="#" class="text-white text-decoration-none small">Mi Cuenta</a></p>
                    <p><a href="#" class="text-white text-decoration-none small">Ayuda</a></p>
                </div>
                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 fw-bold">Contacto</h6>
                    <p class="small"><i class="bi bi-house-door-fill me-2"></i> Ciudad, País</p>
                    <p class="small"><i class="bi bi-envelope-fill me-2"></i> info@prograweb.com</p>
                </div>
            </div>
            <hr class="mb-4">
            <div class="text-center">
                <p class="small mb-0">&copy; <?php echo date('Y'); ?> PrograWeb Academy. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>