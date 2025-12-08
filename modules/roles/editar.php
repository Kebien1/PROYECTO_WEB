<?php 
include("../../config/bd.php"); 
if(isset($_GET["txtID"])){
    $txtID = $_GET["txtID"];
    $sentencia = $conexion->prepare("SELECT * FROM rol WHERE ID = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    if($registro) $Descrip = $registro["Descrip"];
}
if($_POST){
    $txtID = $_POST["ID"];
    $Descrip = $_POST["Descrip"];
    $sentencia = $conexion->prepare("UPDATE rol SET Descrip=:Descrip WHERE ID=:id");
    $sentencia->bindParam(":Descrip",$Descrip);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php"); exit;
}
include("../../includes/header.php");
?>
<div class="card col-md-6 mx-auto">
    <div class="card-header">Editar Rol</div>
    <div class="card-body">
        <form action="" method="post">
            <input type="hidden" name="ID" value="<?php echo $txtID; ?>">
            <div class="mb-3"><label>Nombre del Rol:</label><input type="text" class="form-control" name="Descrip" value="<?php echo $Descrip; ?>" required></div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a class="btn btn-secondary" href="index.php">Cancelar</a>
        </form>
    </div>
</div>