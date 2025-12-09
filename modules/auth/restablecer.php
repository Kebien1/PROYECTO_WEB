<?php
// Archivo: modules/auth/restablecer.php
session_start();
include("../../config/bd.php");

$error = "";
$mensaje = "";
$mostrarFormulario = true;
$token = $_GET['token'] ?? '';

if (empty($token)) {
    header("Location: login.php");
    exit;
}

$horaActual = date("Y-m-d H:i:s");
$sentencia = $conexion->prepare("SELECT * FROM usuario WHERE token_recovery = :token AND token_expiry > :hora");
$sentencia->bindParam(":token", $token);
$sentencia->bindParam(":hora", $horaActual);
$sentencia->execute();
$usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    $error = "Enlace inválido o expirado.";
    $mostrarFormulario = false;
}

if ($_POST && $mostrarFormulario) {
    $pass1 = $_POST['Password'];
    $pass2 = $_POST['ConfirmPassword'];

    if ($pass1 === $pass2) {
        $update = $conexion->prepare("UPDATE usuario SET Password = :pass, token_recovery = NULL, token_expiry = NULL WHERE ID = :id");
        $update->bindParam(":pass", $pass1);
        $update->bindParam(":id", $usuario['ID']);
        $update->execute();

        $mensaje = "¡Contraseña actualizada!";
        $mostrarFormulario = false;
        header("refresh:3;url=login.php");
    } else {
        $error = "Las contraseñas no coinciden.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Nueva Contraseña</title>
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
                        <i class="bi bi-shield-lock-fill text-primary display-1"></i>
                        <h3 class="fw-bold mt-3">Nueva Contraseña</h3>
                    </div>

                    <?php if($error) { ?>
                        <div class="alert alert-danger shadow-sm text-center"><?php echo $error; ?></div>
                    <?php } ?>

                    <?php if($mensaje) { ?>
                        <div class="alert alert-success shadow-sm text-center">
                            <?php echo $mensaje; ?><br><small>Redirigiendo...</small>
                        </div>
                    <?php } ?>
                    
                    <?php if($mostrarFormulario) { ?>
                    <form action="" method="post">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="p1" name="Password" placeholder="Nueva" required>
                            <label for="p1">Nueva Contraseña</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control rounded-3" id="p2" name="ConfirmPassword" placeholder="Confirmar" required>
                            <label for="p2">Confirmar Contraseña</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-3 rounded-3 fw-bold shadow-sm">
                            <i class="bi bi-save-fill me-2"></i> Guardar
                        </button>
                    </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>