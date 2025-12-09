<?php
// Archivo: modules/auth/recuperar.php
session_start();
include("../../config/bd.php");
require_once("../../includes/mail_functions.php");

$mensaje = "";
$error = "";

if ($_POST) {
    $email = $_POST['Email'] ?? '';

    if (!empty($email)) {
        // Verificar si el usuario existe
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE Email = :email");
        $sentencia->bindParam(":email", $email);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            // Generar token y fecha de expiración
            $token = bin2hex(random_bytes(32)); 
            $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

            // Guardar en BD
            $update = $conexion->prepare("UPDATE usuario SET token_recovery = :token, token_expiry = :expira WHERE ID = :id");
            $update->bindParam(":token", $token);
            $update->bindParam(":expira", $expira);
            $update->bindParam(":id", $usuario['ID']);
            $update->execute();

            // Enviar correo
            $link = $base_url . "modules/auth/restablecer.php?token=" . $token;

            if (enviarEmailRecuperacion($email, $usuario['Nick'], $link)) {
                $mensaje = "Hemos enviado un enlace a tu correo ($email).";
            } else {
                $error = "Error al enviar el correo. Intenta más tarde.";
            }
        } else {
            $error = "No encontramos ninguna cuenta con ese correo.";
        }
    } else {
        $error = "Por favor ingresa tu correo.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Recuperar Contraseña</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-envelope-paper-heart-fill text-warning display-1"></i>
                        <h3 class="fw-bold mt-3">¿Olvidaste tu clave?</h3>
                        <p class="text-muted small">Ingresa tu correo para recuperarla.</p>
                    </div>

                    <?php if($mensaje) { ?>
                        <div class="alert alert-success shadow-sm text-center">
                            <i class="bi bi-check-circle-fill me-2"></i><?php echo $mensaje; ?>
                        </div>
                    <?php } ?>

                    <?php if($error) { ?>
                        <div class="alert alert-danger shadow-sm text-center">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo $error; ?>
                        </div>
                    <?php } ?>
                    
                    <?php if(empty($mensaje)) { ?>
                    <form action="" method="post">
                        <div class="form-floating mb-4">
                            <input type="email" class="form-control rounded-3" id="email" name="Email" placeholder="Correo" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-3 rounded-3 fw-bold shadow-sm">
                            <i class="bi bi-send-fill me-2"></i> Enviar Enlace
                        </button>
                    </form>
                    <?php } ?>
                    
                    <div class="text-center mt-4">
                        <a href="login.php" class="text-decoration-none text-muted fw-bold">
                            <i class="bi bi-arrow-left me-1"></i> Volver al Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>