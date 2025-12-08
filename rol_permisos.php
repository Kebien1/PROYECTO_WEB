<?php 
include("bd.php");

// OBTENER EL ID DEL ROL
if(isset($_GET["idRol"])){
    $idRol = $_GET["idRol"];
    
    // OBTENER DATOS DEL ROL
    $sentencia = $conexion->prepare("SELECT * FROM rol WHERE ID = :id");
    $sentencia->bindParam(":id", $idRol);
    $sentencia->execute();
    $rol = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if(!$rol){
        header("Location:rol.php");
        exit;
    }
} else {
    header("Location:rol.php");
    exit;
}

// PROCESAR CUANDO SE ENVÍA EL FORMULARIO
if($_POST){
    // PRIMERO ELIMINAR TODOS LOS PERMISOS ACTUALES DEL ROL
    $sentencia = $conexion->prepare("DELETE FROM detalles WHERE IdRol = :idRol");
    $sentencia->bindParam(":idRol", $idRol);
    $sentencia->execute();
    
    // LUEGO INSERTAR LOS NUEVOS PERMISOS SELECCIONADOS
    if(isset($_POST["permisos"])){
        $permisos = $_POST["permisos"];
        
        foreach($permisos as $idPermiso){
            $sentencia = $conexion->prepare("INSERT INTO detalles(IdRol, IdPermiso) VALUES (:idRol, :idPermiso)");
            $sentencia->bindParam(":idRol", $idRol);
            $sentencia->bindParam(":idPermiso", $idPermiso);
            $sentencia->execute();
        }
    }
    
    $mensaje = "Permisos actualizados correctamente";
    header("Location:rol_permisos.php?idRol=".$idRol."&mensaje=".$mensaje);
    exit;
}

// OBTENER TODOS LOS PERMISOS DISPONIBLES
$sentencia = $conexion->prepare("SELECT * FROM permisos");
$sentencia->execute();
$lista_permisos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("header.php");
?>

<?php if(isset($_GET['mensaje'])) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i>
        <?php echo $_GET['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>

<br>
<div class="card">
    <div class="card-header">
        Gestionar Permisos del Rol: <strong><?php echo $rol['Descrip']; ?></strong>
    </div>
    <div class="card-body">
        
        <form action="" method="post">
            
            <div class="mb-3">
                <label class="form-label">Seleccione los permisos:</label>
                
                <?php 
                if(count($lista_permisos) > 0) {
                    foreach($lista_permisos as $permiso) { 
                        // VERIFICAR SI ESTE PERMISO YA ESTÁ ASIGNADO AL ROL
                        $sentencia = $conexion->prepare("SELECT * FROM detalles WHERE IdRol = :idRol AND IdPermiso = :idPermiso");
                        $sentencia->bindParam(":idRol", $idRol);
                        $sentencia->bindParam(":idPermiso", $permiso['ID']);
                        $sentencia->execute();
                        $existe = $sentencia->fetch(PDO::FETCH_LAZY);
                        
                        $checked = "";
                        if($existe){
                            $checked = "checked";
                        }
                ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permisos[]" 
                                value="<?php echo $permiso['ID']; ?>" 
                                id="permiso_<?php echo $permiso['ID']; ?>"
                                <?php echo $checked; ?>>
                        <label class="form-check-label" for="permiso_<?php echo $permiso['ID']; ?>">
                            <?php echo $permiso['Descrip']; ?>
                        </label>
                    </div>
                <?php 
                    } 
                } else { ?>
                    <div class="alert alert-warning">
                        No hay permisos disponibles. Por favor, cree permisos primero.
                    </div>
                <?php } ?>
            </div>
            
            <button type="submit" class="btn btn-success btn-lg">Guardar Permisos</button>
            <a name="" id="" class="btn btn-primary btn-lg" href="rol.php" role="button">Cancelar</a>
        </form>
    </div>
</div>