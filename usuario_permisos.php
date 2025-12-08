<?php 
include("bd.php");

// OBTENER EL ID DEL USUARIO
if(isset($_GET["idUsuario"])){
    $idUsuario = $_GET["idUsuario"];
    
    // OBTENER DATOS DEL USUARIO CON SU ROL
    $sentencia = $conexion->prepare("SELECT u.*, r.Descrip as RolNombre 
                                      FROM usuario u 
                                      LEFT JOIN rol r ON u.IdRol = r.ID 
                                      WHERE u.ID = :id");
    $sentencia->bindParam(":id", $idUsuario);
    $sentencia->execute();
    $usuario = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if(!$usuario){
        header("Location:index.php");
        exit;
    }
} else {
    header("Location:index.php");
    exit;
}

// OBTENER LOS PERMISOS DEL ROL DEL USUARIO
$sentencia = $conexion->prepare("SELECT p.* 
                                    FROM permisos p
                                    INNER JOIN detalles d ON p.ID = d.IdPermiso
                                    WHERE d.IdRol = :idRol");
$sentencia->bindParam(":idRol", $usuario['IdRol']);
$sentencia->execute();
$lista_permisos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("header.php");
?>

<br>
<div class="card">
    <div class="card-header">
        Permisos del Usuario: <strong><?php echo $usuario['Nick']; ?></strong>
    </div>
    <div class="card-body">
        
        <div class="mb-3">
            <p><strong>ID:</strong> <?php echo $usuario['ID']; ?></p>
            <p><strong>Usuario:</strong> <?php echo $usuario['Nick']; ?></p>
            <p><strong>Email:</strong> <?php echo $usuario['Email']; ?></p>
            <p><strong>Rol:</strong> <?php echo $usuario['RolNombre']; ?></p>
            <p><strong>Estado:</strong> 
                <?php if($usuario['Estado'] == 1) { ?>
                    <span class="badge bg-success">ACTIVO</span>
                <?php } else { ?>
                    <span class="badge bg-danger">INACTIVO</span>
                <?php } ?>
            </p>
        </div>
        
        <hr>
        
        <h5>Permisos Asignados:</h5>
        
        <?php if(count($lista_permisos) > 0) { ?>
            <ul class="list-group">
                <?php foreach($lista_permisos as $permiso) { ?>
                    <li class="list-group-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        <?php echo $permiso['Descrip']; ?>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="alert alert-warning">
                Este usuario no tiene permisos asignados porque su rol no tiene permisos configurados.
                <br><br>
                <a href="rol_permisos.php?idRol=<?php echo $usuario['IdRol']; ?>" class="btn btn-warning">
                    Configurar permisos del rol
                </a>
            </div>
        <?php } ?>
        
        <br>
        <a name="" id="" class="btn btn-primary btn-lg" href="index.php" role="button">Volver</a>
        <a name="" id="" class="btn btn-success btn-lg" href="editar.php?txtID=<?php echo $usuario['ID']; ?>" role="button">Editar Usuario</a>
    </div>
</div>