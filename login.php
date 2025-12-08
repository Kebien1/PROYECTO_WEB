<?php
// Archivo: login.php
session_start();
include("config/bd.php");

if(isset($_SESSION['usuario_id'])){
    header("Location: modules/usuarios/index.php");
    exit;
}

$error = "";

if($_POST){
    $nick = $_POST["Nick"] ?? "";
    $password = $_POST["Password"] ?? "";
    
    if($nick != "" && $password != ""){
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE Nick = :nick AND Password = :password");
        $sentencia->bindParam(":nick", $nick);
        $sentencia->bindParam(":password", $password);
        $sentencia->execute();
        
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        if($usuario){
            if($usuario['Estado'] == 0){
                $error = "Tu cuenta aún no ha sido verificada. Por favor revisa tu correo.";
            } else {
                // Generar código de verificación para el login
                $codigo_verificacion = sprintf("%06d", mt_rand(1, 999999));
                
                $_SESSION['codigo_login'] = $codigo_verificacion;
                $_SESSION['usuario_login_temp'] = $usuario;
                
                // Enviar código por email
                $asunto = "Código de Acceso - PrograWeb";
                $mensaje = "
                <html>
                <head><title>Código de Acceso</title></head>
                <body>
                    <h2>Verificación de Acceso</h2>
                    <p>Hola <strong>{$usuario['Nick']}</strong>,</p>
                    <p>Tu código de acceso es:</p>
                    <h1 style='color: #007bff; font-size: 32px;'>$codigo_verificacion</h1>
                    <p>Ingresa este código para acceder a tu cuenta.</p>
                    <p>Si no fuiste tú, ignora este mensaje.</p>
                </body>
                </html>
                ";
                
                $headers = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=utf-8\r\n";
                $headers .= "From: PrograWeb <noreply@prograweb.com>\r\n";
                
                // Reemplaza la sección de envío de email con:
require_once("includes/mail_functions.php");

if(enviarCodigoVerificacion($usuario['Email'], $usuario['Nick'], $codigo_verificacion, 'login')){
    header("Location: verify_login.php");
    exit;
} else {
    $error = "Error al enviar el código. Intenta nuevamente.";
}
            }
        } else {
            $error = "Usuario o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor complete todos los campos.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Login - Sistema Web</title>
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
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3><i class="bi bi-shield-lock"></i> PrograWeb</h3>
                        <p class="mb-0">Iniciar Sesión</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if($error != "") { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>
                        
                        <?php if(isset($_GET['verificado'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="bi bi-check-circle-fill"></i> Cuenta verificada. Ahora puedes iniciar sesión.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>
                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Usuario:</label>
                                <input type="text" class="form-control" name="Nick" placeholder="Ingrese su usuario" required autofocus>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="Password" placeholder="Ingrese su contraseña" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <p class="mb-0">¿No tienes cuenta? <a href="register.php" class="text-decoration-none">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>