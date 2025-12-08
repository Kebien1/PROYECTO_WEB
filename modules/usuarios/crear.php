<?php 
include("../../config/bd.php"); 
if($_POST){
    $usuario = $_POST["Nick"] ?? "";
    $clave   = $_POST["Password"] ?? "";
    $Email   = $_POST["Email"] ?? "";
    $IdRol   = $_POST["IdRol"] ?? "";
    $estado  = $_POST["Estado"] ?? "";

    if($usuario && $clave && $Email) {
        $sentencia = $conexion->prepare("INSERT INTO usuario(Nick,Password,Email,Estado,IdRol) VALUES (:Nick,:Password,:Email,:Estado,:IdRol)");
        $sentencia->bindParam(":Nick", $usuario);
        $sentencia->bindParam(":Password", $clave);
        $sentencia->bindParam(":Email", $Email);
        $sentencia->bindParam(":Estado", $estado);
        $sentencia->bindParam(":IdRol", $IdRol);
        $sentencia->execute();
        header("Location:index.php");
        exit;
    }
}
include("../../includes/header.php");
?>
<div class="card col-md-6 mx-auto">
    <div class="card-header">Nuevo Usuario</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3"><label>Usuario:</label><input type="text" class="form-control" name="Nick" required></div>
            <div class="mb-3"><label>Contraseña:</label><input type="password" class="form-control" name="Password" required></div>
            <div class="mb-3"><label>Email:</label><input type="email" class="form-control" name="Email" required></div>
            <div class="mb-3">
                <label>Rol:</label>
                <select name="IdRol" class="form-select" required>
                    <option value="1">ADMINISTRADOR</option>
                    <option value="2">ESTUDIANTE</option>
                    <option value="3">DOCENTE</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Estado:</label>
                <select name="Estado" class="form-select" required>
                    <option value="1">ACTIVO</option>
                    <option value="0">INACTIVO</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>