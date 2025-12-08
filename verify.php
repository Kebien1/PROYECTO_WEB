<?php
// Archivo: verify.php
session_start();
include("config/bd.php");

if(!isset($_SESSION['codigo_verificacion']) || !isset($_SESSION['usuario_registro_id'])){
    header("Location: register.php");
    exit;
}

$error = "";

if($_POST){
    $codigo_ingresado = $_POST["codigo"] ?? "";
    
    if($codigo_ingresado == $_SESSION['codigo_verificacion']){
        // Activar usuario
        $usuario_id = $_SESSION['usuario_registro_id'];
        $sentencia = $conexion->prepare("UPDATE usuario SET Estado = 1 WHERE ID = :id");
        $sentencia->bindParam(":id", $usuario_id);
        $sentencia->execute();
        
        // Obtener datos del usuario
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE ID = :id");
        $sentencia->bindParam(":id", $usuario_id);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        // Iniciar sesión automáticamente
        $_SESSION['usuario_id'] = $usuario['ID'];
        $_SESSION['usuario_nick'] = $usuario['Nick'];
        $_SESSION['usuario_email'] = $usuario['Email'];
        $_SESSION['usuario_rol'] = $usuario['IdRol'];
        
        // Limpiar variables temporales
        unset($_SESSION['codigo_verificacion']);
        unset($_SESSION['usuario_registro_id']);
        unset($_SESSION['email_verificacion']);
        
        header("Location: modules/usuarios/index.php?mensaje=Cuenta verificada exitosamente");
        exit;
    } else {
        $error = "Código incorrecto. Por favor verifica tu email.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Verificación - Sistema Web</title>
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
                    <div class="card-header bg-warning text-white text-center py-4">
                        <h3><i class="bi bi-envelope-check"></i> Verificación de Email</h3>
                        <p class="mb-0">Ingresa el código enviado</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            Hemos enviado un código de 6 dígitos a: <strong><?php echo $_SESSION['email_verificacion']; ?></strong>
                        </div>
                        
                        <?php if($error != "") { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <i class="bi bi-exclamation-triangle-fill"></i> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php } ?>
                        
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Código de Verificación:</label>
                                <input type="text" class="form-control text-center" name="codigo" placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus style="font-size: 24px; letter-spacing: 5px;">
                                <small class="text-muted">Ingresa el código de 6 dígitos</small>
                            </div>
                            
                            <button type="submit" class="btn btn-warning w-100 mb-3">
                                <i class="bi bi-check-circle"></i> Verificar
                            </button>
                        </form>
                        
                        <hr>
                        <div class="text-center">
                            <p class="mb-0">¿No recibiste el código? <a href="resend_code.php" class="text-decoration-none">Reenviar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>