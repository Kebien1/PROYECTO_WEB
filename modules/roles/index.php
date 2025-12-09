<?php 
include("../../config/bd.php"); 

if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia=$conexion->prepare("DELETE FROM rol WHERE ID=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje=Rol eliminado"); exit;
}
$sentencia=$conexion->prepare("SELECT * FROM rol");
$sentencia->execute();
$lista_roles = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../includes/header.php");
?>

<?php if(isset($_GET['mensaje'])) { ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <?php echo $_GET['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-lock-fill text-primary me-2"></i>Roles</h5>
        <a class="btn btn-primary" href="crear.php"><i class="bi bi-plus-lg me-1"></i>Nuevo Rol</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 w-25">ID</th>
                        <th>Descripción</th>
                        <th class="text-end pe-4 w-25">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_roles as $registro) { ?>
                    <tr>
                        <td class="ps-4"><strong>#<?php echo $registro['ID']; ?></strong></td>
                        <td><?php echo $registro['Descrip']; ?></td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm">
                                <a class="btn btn-sm btn-outline-info" href="permisos.php?idRol=<?php echo $registro['ID']; ?>">Permisos</a>
                                <a class="btn btn-sm btn-outline-warning" href="editar.php?txtID=<?php echo $registro['ID']; ?>">Editar</a>
                                <a class="btn btn-sm btn-outline-danger" href="index.php?txtID=<?php echo $registro['ID']; ?>" onclick="return confirm('¿Borrar rol?')">Eliminar</a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>