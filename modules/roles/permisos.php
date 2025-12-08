<?php 
include("../../config/bd.php");
if(!isset($_GET["idRol"])){ header("Location:index.php"); exit; }
$idRol = $_GET["idRol"];

$sentencia = $conexion->prepare("SELECT * FROM rol WHERE ID = :id");
$sentencia->bindParam(":id", $idRol);
$sentencia->execute();
$rol = $sentencia->fetch(PDO::FETCH_LAZY);

if($_POST){
    $sentencia = $conexion->prepare("DELETE FROM detalles WHERE IdRol = :idRol");
    $sentencia->bindParam(":idRol", $idRol);
    $sentencia->execute();
    if(isset($_POST["permisos"])){
        foreach($_POST["permisos"] as $idPermiso){
            $sentencia = $conexion->prepare("INSERT INTO detalles(IdRol, IdPermiso) VALUES (:idRol, :idPermiso)");
            $sentencia->bindParam(":idRol", $idRol);
            $sentencia->bindParam(":idPermiso", $idPermiso);
            $sentencia->execute();
        }
    }
    header("Location:permisos.php?idRol=".$idRol."&mensaje=Actualizado"); exit;
}

$sentencia = $conexion->prepare("SELECT * FROM permisos");
$sentencia->execute();
$lista_permisos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../includes/header.php");
?>
<?php if(isset($_GET['mensaje'])) { ?><div class="alert alert-success"><?php echo $_GET['mensaje']; ?></div><?php } ?>
<div class="card">
    <div class="card-header">Permisos para: <strong><?php echo $rol['Descrip']; ?></strong></div>
    <div class="card-body">
        <form action="" method="post">
            <div class="row">
                <?php foreach($lista_permisos as $permiso) { 
                    $sql = $conexion->prepare("SELECT * FROM detalles WHERE IdRol = :idRol AND IdPermiso = :idP");
                    $sql->bindParam(":idRol", $idRol);
                    $sql->bindParam(":idP", $permiso['ID']);
                    $sql->execute();
                    $checked = ($sql->fetch()) ? "checked" : "";
                ?>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permisos[]" value="<?php echo $permiso['ID']; ?>" id="p<?php echo $permiso['ID']; ?>" <?php echo $checked; ?>>
                        <label class="form-check-label" for="p<?php echo $permiso['ID']; ?>"><?php echo $permiso['Descrip']; ?></label>
                    </div>
                </div>
                <?php } ?>
            </div>
            <br><button type="submit" class="btn btn-success">Guardar</button>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </form>
    </div>
</div>