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
    <title>Login - PrograWeb</title>
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
                        <i class="bi bi-layers-fill text-primary display-4"></i>
                        <h2 class="fw-bold mt-2">Bienvenido</h2>
                        <p class="text-muted">Ingresa tus credenciales para continuar</p>
                    </div>

                    <?php if($error != "") { ?>
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>
                    
                    <?php if(isset($_GET['verificado'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> Cuenta verificada. Inicia sesión.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>
                    
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="floatingInput" name="Nick" placeholder="Usuario" required autofocus>
                            <label for="floatingInput">Nombre de Usuario</label>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" name="Password" placeholder="Contraseña" required>
                            <label for="floatingPassword">Contraseña</label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">¿No tienes cuenta? <a href="register.php" class="text-decoration-none fw-bold">Regístrate aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>