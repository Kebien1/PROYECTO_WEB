<?php 
include("../../config/bd.php"); 
if($_POST){
    $Descrip=$_POST["Descrip"] ?? "";
    if($Descrip != "") {
        $sentencia=$conexion->prepare("INSERT INTO rol(Descrip) VALUES (:Descrip)");
        $sentencia->bindParam(":Descrip",$Descrip);
        $sentencia->execute();
        header("Location:index.php"); exit;
    }
}
include("../../includes/header.php");
?>
<div class="card col-md-6 mx-auto">
    <div class="card-header">Nuevo Rol</div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3"><label>Nombre del Rol:</label><input type="text" class="form-control" name="Descrip" required></div>
            <button type="submit" class="btn btn-success">Guardar</button>
            <a class="btn btn-secondary" href="index.php">Cancelar</a>
        </form>
    </div>
</div>