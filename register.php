<?php
// Archivo: register.php
session_start();
include("config/bd.php");
require_once("includes/mail_functions.php");

if(isset($_SESSION['usuario_id'])){
    header("Location: modules/usuarios/index.php");
    exit;
}

$error = "";
$success = "";

if($_POST){
    $nick = $_POST["Nick"] ?? "";
    $email = $_POST["Email"] ?? "";
    $password = $_POST["Password"] ?? "";
    $confirm_password = $_POST["ConfirmPassword"] ?? "";
    $idRol = $_POST["IdRol"] ?? "";
    
    if($nick != "" && $email != "" && $password != "" && $confirm_password != "" && $idRol != ""){
        
        if($password !== $confirm_password){
            $error = "Las contraseñas no coinciden.";
        } else {
            // Verificar si el usuario ya existe
            $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE Nick = :nick OR Email = :email");
            $sentencia->bindParam(":nick", $nick);
            $sentencia->bindParam(":email", $email);
            $sentencia->execute();
            
            if($sentencia->fetch()){
                $error = "El usuario o email ya están registrados.";
            } else {
                // Generar código de verificación de 6 dígitos
                $codigo_verificacion = sprintf("%06d", mt_rand(1, 999999));
                
                // Insertar usuario con estado inactivo (0)
                $sentencia = $conexion->prepare("INSERT INTO usuario(Nick, Password, Email, Estado, IdRol) VALUES (:nick, :password, :email, 0, :idRol)");
                $sentencia->bindParam(":nick", $nick);
                $sentencia->bindParam(":password", $password);
                $sentencia->bindParam(":email", $email);
                $sentencia->bindParam(":idRol", $idRol);
                $sentencia->execute();
                
                $usuario_id = $conexion->lastInsertId();
                
                // Guardar código en sesión temporal
                $_SESSION['codigo_verificacion'] = $codigo_verificacion;
                $_SESSION['usuario_registro_id'] = $usuario_id;
                $_SESSION['email_verificacion'] = $email;
                $_SESSION['nick_verificacion'] = $nick;
                
                // Reemplaza la sección de envío de email con:
require_once("includes/mail_functions.php");

if(enviarCodigoVerificacion($email, $nick, $codigo_verificacion, 'registro')){
    header("Location: verify.php");
    exit;
} else {
    $error = "Error al enviar el correo. Intenta nuevamente.";
}
            }
        }
    } else {
        $error = "Por favor complete todos los campos.";
    }
}

// Obtener roles disponibles
$sentencia = $conexion->prepare("SELECT * FROM rol");
$sentencia->execute();
$roles = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <title>Registro - Sistema Web</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h3><i class="bi bi-person-plus"></i> Registro de Usuario</h3>
                        <p class="mb-0">Crea tu cuenta en PrograWeb</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if($error != "") { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>
                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Usuario:</label>
                                <input type="text" class="form-control" name="Nick" placeholder="Elige un nombre de usuario" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="Email" placeholder="tu@email.com" required>
                                <small class="text-muted">Se enviará un código de verificación a este correo</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" name="Password" placeholder="Mínimo 6 caracteres" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Confirmar Contraseña:</label>
                                <input type="password" class="form-control" name="ConfirmPassword" placeholder="Repite tu contraseña" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Registrarse como:</label>
                                <select name="IdRol" class="form-select" required>
                                    <option value="">Seleccione un rol...</option>
                                    <?php foreach($roles as $rol) { ?>
                                        <option value="<?php echo $rol['ID']; ?>"><?php echo $rol['Descrip']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 mb-3">
                                <i class="bi bi-person-check"></i> Registrarse
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <p class="mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none">Iniciar Sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>