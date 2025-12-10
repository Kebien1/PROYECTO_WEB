<?php
// Archivo: modules/auth/register.php
session_start();
include("../../config/bd.php");

$error = "";
$roles = $conexion->query("SELECT * FROM rol")->fetchAll(PDO::FETCH_ASSOC);

if($_POST){
    $nick = $_POST["Nick"];
    $email = $_POST["Email"];
    $password = $_POST["Password"];
    $idRol = $_POST["IdRol"];
    
    $check = $conexion->prepare("SELECT ID FROM usuario WHERE Nick = :n OR Email = :e");
    $check->bindParam(":n", $nick);
    $check->bindParam(":e", $email);
    $check->execute();

    if($check->fetch()){
        $error = "El usuario o el correo ya existen.";
    } else {
        $sentencia = $conexion->prepare("INSERT INTO usuario(Nick, Password, Email, Estado, IdRol) VALUES (:n, :p, :e, 1, :r)");
        $sentencia->bindParam(":n", $nick);
        $sentencia->bindParam(":p", $password);
        $sentencia->bindParam(":e", $email);
        $sentencia->bindParam(":r", $idRol);
        $sentencia->execute();
        header("Location: login.php");
        exit;
    }
}
?>
<!doctype html>
<html lang="es">
<head>
    <title>Registro</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
    
    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 450px;">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <i class="bi bi-person-plus-fill display-4 text-success"></i>
                <h3 class="fw-bold mt-3">Crear Cuenta</h3>
            </div>
            
            <?php if($error) { ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>
                    <div><?php echo $error; ?></div>
                </div>
            <?php } ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label class="form-label fw-bold">Usuario</label>
                    <input type="text" name="Nick" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" name="Email" class="form-control form-control-lg" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Contraseña</label>
                    <input type="password" name="Password" class="form-control form-control-lg" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold">Rol</label>
                    <select name="IdRol" class="form-select form-select-lg" required>
                        <option value="">Seleccione...</option>
                        <?php foreach($roles as $rol) { ?>
                            <option value="<?php echo $rol['ID']; ?>"><?php echo $rol['Descrip']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg fw-bold">Registrarse</button>
                </div>
            </form>
            <div class="text-center">
                <a href="login.php" class="text-decoration-none">¿Ya tienes cuenta? Iniciar Sesión</a>
            </div>
        </div>
    </div>

</body>
</html>