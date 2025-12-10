<?php
// Archivo: modules/auth/restablecer.php
session_start();
include("../../config/bd.php");

$token = $_GET['token'] ?? '';
$mensaje = "";
$mostrar_form = false;

$horaActual = date("Y-m-d H:i:s");
$sentencia = $conexion->prepare("SELECT * FROM usuario WHERE token_recovery = :t AND token_expiry > :h");
$sentencia->bindParam(":t", $token);
$sentencia->bindParam(":h", $horaActual);
$sentencia->execute();
$usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

if($usuario){
    $mostrar_form = true;
} else {
    $mensaje = "El enlace no es válido o ya expiró.";
}

if($_POST && $mostrar_form){
    $pass1 = $_POST['Password'];
    $pass2 = $_POST['ConfirmPassword'];

    if($pass1 === $pass2){
        $update = $conexion->prepare("UPDATE usuario SET Password = :p, token_recovery = NULL WHERE ID = :id");
        $update->bindParam(":p", $pass1);
        $update->bindParam(":id", $usuario['ID']);
        $update->execute();

        $mensaje = "¡Contraseña actualizada con éxito!";
        $mostrar_form = false;
        header("refresh:3;url=login.php");
    } else {
        $mensaje = "Las contraseñas no coinciden.";
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Nueva Contraseña</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    
    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-shield-lock-fill display-4 text-primary"></i>
                <h4 class="fw-bold mt-3">Nueva Contraseña</h4>
            </div>

            <?php if($mensaje) { ?>
                <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
            <?php } ?>

            <?php if($mostrar_form) { ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nueva Contraseña</label>
                    <input type="password" name="Password" class="form-control form-control-lg" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Confirmar</label>
                    <input type="password" name="ConfirmPassword" class="form-control form-control-lg" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold">Guardar</button>
                </div>
            </form>
            <?php } else { ?>
                <div class="d-grid mt-3">
                    <a href="login.php" class="btn btn-secondary">Volver al Login</a>
                </div>
            <?php } ?>
        </div>
    </div>

</body>
</html>