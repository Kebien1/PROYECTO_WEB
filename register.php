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
                $codigo_verificacion = sprintf("%06d", mt_rand(1, 999999));
                
                $sentencia = $conexion->prepare("INSERT INTO usuario(Nick, Password, Email, Estado, IdRol) VALUES (:nick, :password, :email, 0, :idRol)");
                $sentencia->bindParam(":nick", $nick);
                $sentencia->bindParam(":password", $password);
                $sentencia->bindParam(":email", $email);
                $sentencia->bindParam(":idRol", $idRol);
                $sentencia->execute();
                
                $usuario_id = $conexion->lastInsertId();
                
                $_SESSION['codigo_verificacion'] = $codigo_verificacion;
                $_SESSION['usuario_registro_id'] = $usuario_id;
                $_SESSION['email_verificacion'] = $email;
                $_SESSION['nick_verificacion'] = $nick;
                
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
    <title>Registro - PrograWeb</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill text-success display-4"></i>
                        <h2 class="fw-bold mt-2">Crear Cuenta</h2>
                        <p class="text-muted">Únete a PrograWeb</p>
                    </div>

                    <?php if($error != "") { ?>
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>
                    
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control rounded-3" id="nick" name="Nick" placeholder="Usuario" required>
                            <label for="nick">Nombre de Usuario</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="email" name="Email" placeholder="Email" required>
                            <label for="email">Correo Electrónico</label>
                        </div>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control rounded-3" id="pass" name="Password" placeholder="Password" required>
                                    <label for="pass">Contraseña</label>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-floating">
                                    <input type="password" class="form-control rounded-3" id="confirmPass" name="ConfirmPassword" placeholder="Confirm" required>
                                    <label for="confirmPass">Confirmar</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <select name="IdRol" class="form-select rounded-3" id="rol" required>
                                <option value="">Seleccione...</option>
                                <?php foreach($roles as $rol) { ?>
                                    <option value="<?php echo $rol['ID']; ?>"><?php echo $rol['Descrip']; ?></option>
                                <?php } ?>
                            </select>
                            <label for="rol">Registrarse como</label>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold shadow-sm">
                            <i class="bi bi-person-check-fill me-2"></i> Registrarse
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-muted mb-0">¿Ya tienes cuenta? <a href="login.php" class="text-decoration-none fw-bold text-success">Iniciar Sesión</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>