<?php
// Archivo: modules/auth/login.php
session_start();
include("../../config/bd.php");
require_once("../../includes/mail_functions.php");

if(isset($_SESSION['usuario_id'])){
    header("Location: ../../index.php");
    exit;
}

$mensaje = "";

if($_POST){
    $nick = $_POST["Nick"] ?? "";
    $password = $_POST["Password"] ?? "";
    
    // 1. Buscar usuario
    $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE Nick = :nick AND Password = :password");
    $sentencia->bindParam(":nick", $nick);
    $sentencia->bindParam(":password", $password);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
    
    if($usuario){
        // 2. Si las credenciales son buenas, generamos el CÓDIGO
        $codigo = sprintf("%06d", mt_rand(1, 999999)); // Genera número ej: 458921
        
        // 3. Guardamos datos temporalmente (NO iniciamos sesión completa aún)
        $_SESSION['login_temp_user'] = $usuario;
        $_SESSION['login_codigo'] = $codigo;
        
        // 4. Enviamos el código al correo
        if(enviarCodigoVerificacion($usuario['Email'], $usuario['Nick'], $codigo)){
            header("Location: verify_login.php"); // Vamos a la pantalla de código
            exit;
        } else {
            $mensaje = "Error al enviar el código de verificación.";
        }
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Login - Seguridad</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-circle display-4 text-primary"></i>
                <h3 class="fw-bold mt-3">Iniciar Sesión</h3>
            </div>
            
            <?php if($mensaje) { ?>
                <div class="alert alert-danger text-center small"><?php echo $mensaje; ?></div>
            <?php } ?>

            <form action="" method="post">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="Nick" placeholder="Usuario" required>
                    <label>Usuario</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="Password" placeholder="Contraseña" required>
                    <label>Contraseña</label>
                </div>
                <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold mb-3">Ingresar</button>
            </form>
            
            <div class="text-center">
                <a href="recuperar.php" class="text-decoration-none small">¿Olvidaste tu contraseña?</a><br>
                <a href="register.php" class="text-decoration-none small text-secondary">Registrarse</a><br>
                <hr>
                <a href="../../index.php" class="btn btn-sm btn-outline-secondary">Volver al Inicio</a>
            </div>
        </div>
    </div>
</body>
</html>