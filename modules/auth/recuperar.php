<?php
// Archivo: modules/auth/recuperar.php
session_start();
include("../../config/bd.php");
require_once("../../includes/mail_functions.php");

$mensaje = "";
$clase_alerta = "";

if($_POST){
    $email = $_POST['Email'];
    $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE Email = :email");
    $sentencia->bindParam(":email", $email);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if($usuario){
        $token = bin2hex(random_bytes(32));
        $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $update = $conexion->prepare("UPDATE usuario SET token_recovery = :t, token_expiry = :e WHERE ID = :id");
        $update->bindParam(":t", $token);
        $update->bindParam(":e", $expira);
        $update->bindParam(":id", $usuario['ID']);
        $update->execute();

        $link = $base_url . "modules/auth/restablecer.php?token=" . $token;

        if(enviarEmailRecuperacion($email, $usuario['Nick'], $link)){
            $mensaje = "Correo enviado con éxito. Revisa tu bandeja de entrada.";
            $clase_alerta = "alert-success";
        } else {
            $mensaje = "Error al enviar el correo. Intenta más tarde.";
            $clase_alerta = "alert-danger";
        }
    } else {
        $mensaje = "No existe una cuenta con ese correo.";
        $clase_alerta = "alert-warning";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Recuperar Contraseña</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    
    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-envelope-at-fill display-4 text-warning"></i>
                <h4 class="fw-bold mt-3">Recuperar Acceso</h4>
                <p class="text-muted small">Ingresa tu email para restablecer la clave</p>
            </div>

            <?php if($mensaje) { ?>
                <div class="alert <?php echo $clase_alerta; ?> text-center" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php } ?>

            <form action="" method="post">
                <div class="mb-4">
                    <label class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" name="Email" class="form-control form-control-lg" placeholder="ejemplo@correo.com" required>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-warning btn-lg fw-bold text-dark">
                        <i class="bi bi-send-fill me-2"></i>Enviar Enlace
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="login.php" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Volver al Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>