<?php 
// IMPORTA LA CONEXION A LA BASE DE DATOS
include("bd.php"); 

// VERIFICA SI HAY UN ID PARA EDITAR
if(isset($_GET["txtID"])){
    $txtID = (isset($_GET["txtID"])) ? $_GET["txtID"] : "";
    
    // BUSCA LOS DATOS DEL PERMISO EN LA BASE DE DATOS
    $sentencia = $conexion->prepare("SELECT * FROM permisos WHERE ID = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    // SI EXISTE LLENA LAS VARIABLES
    if($registro){
        $ID = $registro["ID"];
        $Descrip = $registro["Descrip"];
    }
}

// VERIFICA SI SE ENVIO EL FORMULARIO CON CAMBIOS
if($_POST){
    // RECIBE LOS DATOS EDITADOS
    $txtID = (isset($_POST["ID"])) ? $_POST["ID"] : "";
    $Descrip = (isset($_POST["Descrip"])) ? $_POST["Descrip"] : "";
    
    // ACTUALIZA LA DESCRIPCION EN LA BASE DE DATOS
    $sentencia = $conexion->prepare("UPDATE permisos SET Descrip=:Descrip WHERE ID=:id");
    $sentencia->bindParam(":Descrip",$Descrip);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    // REDIRECCIONA A LA LISTA DE PERMISOS
    $mensaje = "Registro actualizado";
    header("Location:permisos.php");
    exit;
}
?>

<?php 
// CARGA LA CABECERA VISUAL
include("header.php") 
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">
                <i class="bi bi-pencil-square"></i> Editar Permiso
            </h2>
            
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i> Datos del Permiso
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        
                        <input type="hidden" name="ID" value="<?php echo htmlspecialchars($txtID ?? ''); ?>"/>

                        <div class="mb-4">
                            <label for="ID" class="form-label fw-bold">
                                <i class="bi bi-hash"></i> ID:
                            </label>
                            <input type="text" value="<?php echo $txtID; ?>" class="form-control form-control-lg bg-light" 
                                    disabled />
                        </div>

                        <div class="mb-4">
                            <label for="usuario" class="form-label fw-bold">
                                <i class="bi bi-person"></i> descripcion:
                            </label>
                            <input type="text" value="<?php echo $Descrip ?? ''; ?>" class="form-control form-control-lg border-2" 
                                    name="Descrip" id="Descrip" placeholder="" required/>
                            <small class="form-text text-muted d-block mt-2"></small>
                        </div>
                        
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="permisos.php" class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>