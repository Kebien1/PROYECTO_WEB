<?php 
// IMPORTA LA CONEXION A LA BASE DE DATOS
include("bd.php"); 

// VERIFICA SI SE ENVIO EL FORMULARIO
if($_POST){

    // RECIBE EL DATO DE LA DESCRIPCION
    $Descrip=(isset($_POST["Descrip"])?$_POST["Descrip"]:"");

    // REVISA QUE NO ESTE VACIO
    if($Descrip == "" ) {
        $error = "Todos los campos son obligatorios";
    } else {
        
        // GUARDA EL NUEVO PERMISO EN LA BASE DE DATOS
        $sentencia=$conexion->prepare("INSERT INTO permisos(Descrip)
            VALUES (:Descrip)");
        $sentencia->bindParam(":Descrip",$Descrip);
        $sentencia->execute();
        
        // REDIRECCIONA A LA LISTA
        header("Location:permisos.php");
        exit;
    }
}
?>

<?php 
// CARGA LA CABECERA VISUAL
include("header.php") 
?>

<br> <br>
<div class="card">
    <div class="card-header">Datos del Permiso</div>
    <div class="card-body">
        
        <?php 
        // MUESTRA ALERTA SI HAY ERROR
        if(isset($error)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
        
        <form action="" method="post" enctype="multipart/form-data">
            
            <div class="mb-3">
                <label for="Descrip" class="form-label">Permiso:</label>
                <input type="text" class="form-control form-control-lg" name="Descrip" id="Descrip" aria-describedby="helpId"
                placeholder="Ingrese el nombre del permiso" required>
                <small id="helpId" class="form-text text-muted"></small>
            </div>
            
            <button type="submit" class="btn btn-success btn-lg">Guardar</button>
            <a name="" id="" class="btn btn-primary btn-lg" href="permisos.php" role="button">Cancelar</a>
        </form>
    </div>
</div>