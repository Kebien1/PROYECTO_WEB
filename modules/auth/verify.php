<?php
// Archivo: modules/auth/verify.php
session_start();
// Ajuste de ruta: ../../
include("../../config/bd.php");

if(!isset($_SESSION['codigo_verificacion']) || !isset($_SESSION['usuario_registro_id'])){
    header("Location: register.php");
    exit;
}

$error = "";

if($_POST){
    $codigo_ingresado = $_POST["codigo"] ?? "";
    
    if($codigo_ingresado == $_SESSION['codigo_verificacion']){
        $usuario_id = $_SESSION['usuario_registro_id'];
        $sentencia = $conexion->prepare("UPDATE usuario SET Estado = 1 WHERE ID = :id");
        $sentencia->bindParam(":id", $usuario_id);
        $sentencia->execute();
        
        $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE ID = :id");
        $sentencia->bindParam(":id", $usuario_id);
        $sentencia->execute();
        $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);
        
        $_SESSION['usuario_id'] = $usuario['ID'];
        $_SESSION['usuario_nick'] = $usuario['Nick'];
        $_SESSION['usuario_email'] = $usuario['Email'];
        $_SESSION['usuario_rol'] = $usuario['IdRol'];
        
        unset($_SESSION['codigo_verificacion']);
        unset($_SESSION['usuario_registro_id']);
        unset($_SESSION['email_verificacion']);
        
        // Ajuste de ruta: Volvemos al dashboard (../../)
        header("Location: ../../modules/usuarios/index.php?mensaje=Cuenta verificada exitosamente");
        exit;
    } else {
        $error = "Código incorrecto. Por favor verifica tu email.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Verificación - PrograWeb</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
    
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    
                    <div class="mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 80px; height: 80px;">
                            <i class="bi bi-envelope-check-fill display-5"></i>
                        </div>
                        <h3 class="fw-bold mt-3">Verifica tu Email</h3>
                        <p class="text-muted small">Hemos enviado un código de 6 dígitos a:<br><strong><?php echo $_SESSION['email_verificacion']; ?></strong></p>
                    </div>

                    <?php if($error != "") { ?>
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm text-start" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php } ?>
                    
                    <form action="" method="post">
                        <div class="mb-4">
                            <input type="text" class="form-control form-control-lg text-center fs-2 fw-bold rounded-3" name="codigo" placeholder="000000" maxlength="6" pattern="\d{6}" required autofocus>
                            <small class="text-muted">Introduce el código aquí</small>
                        </div>
                        
                        <button type="submit" class="btn btn-warning w-100 py-3 rounded-3 fw-bold shadow-sm text-dark">
                            <i class="bi bi-check-lg me-2"></i> Verificar Cuenta
                        </button>
                    </form>
                    
                    <div class="mt-4">
                        <a href="resend_code.php" class="btn btn-link text-decoration-none text-muted">
                            <i class="bi bi-arrow-clockwise me-1"></i> ¿No recibiste el código? Reenviar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>