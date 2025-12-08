<?php 
include("../../config/bd.php");

if(!isset($_GET["idUsuario"])){ 
    header("Location:index.php"); 
    exit; 
}
$idUsuario = $_GET["idUsuario"];

// 1. Obtener datos del usuario y su rol
$sentencia = $conexion->prepare("SELECT u.*, r.Descrip as RolNombre FROM usuario u LEFT JOIN rol r ON u.IdRol = r.ID WHERE u.ID = :id");
$sentencia->bindParam(":id", $idUsuario);
$sentencia->execute();

// CAMBIO AQUÍ: Usamos FETCH_ASSOC en lugar de FETCH_LAZY
$usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

// Verificamos si se encontró el usuario para evitar errores si está vacío
if(!$usuario) {
    header("Location:index.php");
    exit;
}

// 2. Obtener permisos basados en el rol del usuario
$sentencia = $conexion->prepare("SELECT p.Descrip FROM permisos p INNER JOIN detalles d ON p.ID = d.IdPermiso WHERE d.IdRol = :idRol");

// Ahora esto funcionará sin problemas porque $usuario es un arreglo normal
$sentencia->bindParam(":idRol", $usuario['IdRol']);
$sentencia->execute();
$lista_permisos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../includes/header.php");
?>

<div class="card">
    <div class="card-header">
        Permisos de: <strong><?php echo $usuario['Nick']; ?></strong>
    </div>
    <div class="card-body">
        <h5>Rol: <?php echo $usuario['RolNombre']; ?></h5>
        <hr>
        
        <h6>Permisos asignados:</h6>
        
        <?php if(count($lista_permisos) > 0) { ?>
            <ul class="list-group">
                <?php foreach($lista_permisos as $permiso) { ?>
                    <li class="list-group-item">
                        <i class="bi bi-check-circle-fill text-success"></i> 
                        <?php echo $permiso['Descrip']; ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="alert alert-warning">
                Este usuario no tiene permisos asignados.
            </div>
        <?php } ?>
        
        <br>
        <a href="index.php" class="btn btn-primary">Volver</a>
        
        <a href="<?php echo $base_url; ?>modules/roles/permisos.php?idRol=<?php echo $usuario['IdRol']; ?>" class="btn btn-warning">
            Editar Permisos del Rol
        </a>
    </div>
</div>