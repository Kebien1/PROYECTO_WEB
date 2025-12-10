<?php
// Archivo: modules/auth/verify_login.php
session_start();

// Si no hay un usuario temporal esperando verificación, volver al login
if(!isset($_SESSION['login_temp_user']) || !isset($_SESSION['login_codigo'])){
    header("Location: login.php");
    exit;
}

$mensaje = "";

if($_POST){
    $codigo_ingresado = $_POST['codigo'];
    
    // Comparar código ingresado con el guardado en sesión
    if($codigo_ingresado == $_SESSION['login_codigo']){
        // ¡CÓDIGO CORRECTO! Ahora sí iniciamos la sesión real
        $usuario = $_SESSION['login_temp_user'];
        
        $_SESSION['usuario_id'] = $usuario['ID'];
        $_SESSION['usuario_nick'] = $usuario['Nick'];
        $_SESSION['usuario_email'] = $usuario['Email'];
        $_SESSION['usuario_rol'] = $usuario['IdRol'];
        
        // Limpiamos las variables temporales
        unset($_SESSION['login_temp_user']);
        unset($_SESSION['login_codigo']);
        
        header("Location: ../../index.php");
        exit;
    } else {
        $mensaje = "El código es incorrecto.";
    }
}

// Ocultar parte del correo para mostrarlo en pantalla (estético)
$email_mask = $_SESSION['login_temp_user']['Email'];
?>
<!doctype html>
<html lang="es">
<head>
    <title>Verificación</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5 text-center">
            
            <div class="mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle p-3 mb-3">
                    <i class="bi bi-shield-lock-fill display-4"></i>
                </div>
                <h4 class="fw-bold">Verificación de Seguridad</h4>
                <p class="text-muted small">Ingresa el código enviado a<br><strong><?php echo $email_mask; ?></strong></p>
            </div>

            <?php if($mensaje) { ?>
                <div class="alert alert-danger p-2 small"><?php echo $mensaje; ?></div>
            <?php } ?>
            
            <form action="" method="post">
                <div class="mb-4">
                    <input type="text" class="form-control form-control-lg text-center fw-bold fs-2 letter-spacing-2" 
                            name="codigo" placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus>
                </div>
                <button type="submit" class="btn btn-warning w-100 fw-bold py-2">Confirmar Acceso</button>
            </form>
            
            <div class="mt-4">
                <a href="login.php" class="text-decoration-none small text-muted">Cancelar y volver</a>
            </div>
        </div>
    </div>
</body>
</html>