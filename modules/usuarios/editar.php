<?php 
include("../../config/bd.php"); 
if(isset($_GET["txtID"])){
    $txtID = $_GET["txtID"];
    $sentencia = $conexion->prepare("SELECT * FROM usuario WHERE ID = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    if($registro){
        $Nick = $registro["Nick"];
        $Password = $registro["Password"];
        $Email = $registro["Email"];
        $Estado = $registro["Estado"];
        $IdRol = $registro["IdRol"];
    }
}
if($_POST){
    $txtID = $_POST["ID"];
    $Nick = $_POST["Nick"];
    $Password = $_POST["Password"];
    $Email = $_POST["Email"];
    $Estado = $_POST["Estado"];
    $IdRol = $_POST["IdRol"];
    $sentencia = $conexion->prepare("UPDATE usuario SET Nick=:Nick, Password=:Password, Email=:Email, IdRol=:IdRol, Estado=:Estado WHERE ID=:id");
    $sentencia->bindParam(":Nick",$Nick);
    $sentencia->bindParam(":Password",$Password);
    $sentencia->bindParam(":Email",$Email);
    $sentencia->bindParam(":Estado",$Estado);
    $sentencia->bindParam(":IdRol",$IdRol);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje=Usuario actualizado"); exit;
}
include("../../includes/header.php");
?>
<div class="card col-md-6 mx-auto">
    <div class="card-header">Editar Usuario</div>
    <div class="card-body">
        <form action="" method="post">
            <input type="hidden" name="ID" value="<?php echo $txtID; ?>">
            <div class="mb-3"><label>Usuario:</label><input type="text" class="form-control" name="Nick" value="<?php echo $Nick; ?>" required></div>
            <div class="mb-3"><label>Contraseña:</label><input type="password" class="form-control" name="Password" value="<?php echo $Password; ?>" required></div>
            <div class="mb-3"><label>Email:</label><input type="email" class="form-control" name="Email" value="<?php echo $Email; ?>" required></div>
            <div class="mb-3">
                <label>Rol:</label>
                <select name="IdRol" class="form-select">
                    <option value="<?php echo $IdRol; ?>">Mantener actual</option>
                    <option value="1">ADMINISTRADOR</option>
                    <option value="2">ESTUDIANTE</option>
                    <option value="3">DOCENTE</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Estado:</label>
                <select name="Estado" class="form-select">
                    <option value="<?php echo $Estado; ?>">Mantener actual</option>
                    <option value="1">ACTIVO</option>
                    <option value="0">INACTIVO</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>