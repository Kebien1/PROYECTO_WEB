<?php 
// IMPORTANTE: Incluimos bd.php (según tu foto)
include("../../config/bd.php");

// Borrar Usuario
if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("DELETE FROM usuario WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje=Usuario eliminado");
    exit;
}

// Listar Usuarios
$sentencia = $conexion->prepare("SELECT * FROM usuario");
$sentencia->execute();
$lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../includes/header.php");
?>
<?php if(isset($_GET['mensaje'])) { ?>
    <div class="alert alert-success"><?php echo $_GET['mensaje']; ?></div>
<?php } ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Lista de Usuarios</h4>
        <a class="btn btn-primary" href="crear.php"><i class="bi bi-person-plus"></i> Nuevo</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nick</th>
                    <th>Email</th>
                    <th>ID Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lista_usuarios as $registro) { ?>
                <tr>
                    <td><?php echo $registro['ID']; ?></td>
                    <td><?php echo $registro['Nick']; ?></td>
                    <td><?php echo $registro['Email']; ?></td>
                    <td><?php echo $registro['IdRol']; ?></td>
                    <td><?php echo ($registro['Estado'] == 1) ? "ACTIVO" : "INACTIVO"; ?></td>
                    <td>
                        <a class="btn btn-sm btn-info text-white" href="permisos.php?idUsuario=<?php echo $registro['ID']; ?>">Permisos</a>
                        <a class="btn btn-sm btn-warning" href="editar.php?txtID=<?php echo $registro['ID']; ?>">Editar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>