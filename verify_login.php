<?php
// Archivo: verify_login.php
session_start();
include("config/bd.php");

if(!isset($_SESSION['codigo_login']) || !isset($_SESSION['usuario_login_temp'])){
    header("Location: login.php");
    exit;
}

$error = "";

if($_POST){
    $codigo_ingresado = $_POST["codigo"] ?? "";
    
    if($codigo_ingresado == $_SESSION['codigo_login']){
        $usuario = $_SESSION['usuario_login_temp'];
        
        // Iniciar sesión
        $_SESSION['usuario_id'] = $usuario['ID'];
        $_SESSION['usuario_nick'] = $usuario['Nick'];
        $_SESSION['usuario_email'] = $usuario['Email'];
        $_SESSION['usuario_rol'] = $usuario['IdRol'];
        
        // Limpiar variables temporales
        unset($_SESSION['codigo_login']);
        unset($_SESSION['usuario_login_temp']);
        
        header("Location: modules/usuarios/index.php");
        exit;
    } else {
        $error = "Código incorrecto. Por favor verifica tu email.";
    }
}

$email = $_SESSION['usuario_login_temp']['Email'];
?>
<!doctype html>
<html lang="es">
<head>
    <title>Verificación Login - Sistema Web</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-header bg-info text-white text-center py-4">
                        <h3><i class="bi bi-shield-check"></i> Verificación de Acceso</h3>
                        <p class="mb-0">Confirma tu identidad</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            Hemos enviado un código de seguridad a: <strong><?php echo $email; ?></strong>
                        </div>
                        
                        <?php if($error != "") { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>
                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Código de Seguridad:</label>
                                <input type="text" class="form-control text-center" name="codigo" placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus style="font-size: 24px; letter-spacing: 5px;">
                                <small class="text-muted">Ingresa el código de 6 dígitos</small>
                            </div>
                            
                            <button type="submit" class="btn btn-info w-100 mb-3 text-white">
                                <i class="bi bi-check-circle"></i> Verificar e Ingresar
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <p class="mb-0"><a href="login.php" class="text-decoration-none">Volver al login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>