<?php 
include("../../config/bd.php");

// Lógica de eliminar
if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("DELETE FROM usuario WHERE ID=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje=Usuario eliminado correctamente");
    exit;
}

// Lógica de listar
$sentencia = $conexion->prepare("SELECT u.*, r.Descrip as RolNombre FROM usuario u LEFT JOIN rol r ON u.IdRol = r.ID");
$sentencia->execute();
$lista_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

include("../../includes/header.php");
?>

<?php if(isset($_GET['mensaje'])) { ?>
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i><?php echo $_GET['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark fw-bold"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Usuarios</h5>
        <a class="btn btn-primary" href="crear.php"><i class="bi bi-plus-lg me-1"></i>Nuevo</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th class="py-3">Usuario</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Rol</th>
                        <th class="py-3">Estado</th>
                        <th class="text-end pe-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lista_usuarios as $registro) { ?>
                    <tr>
                        <td class="ps-4 fw-bold">#<?php echo $registro['ID']; ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person-circle fs-4 text-secondary me-2"></i>
                                <span><?php echo $registro['Nick']; ?></span>
                            </div>
                        </td>
                        <td><?php echo $registro['Email']; ?></td>
                        <td>
                            <span class="badge bg-info text-dark rounded-pill"><?php echo $registro['RolNombre'] ?? 'Sin Rol'; ?></span>
                        </td>
                        <td>
                            <?php if($registro['Estado'] == 1) { ?>
                                <span class="badge bg-success rounded-pill">Activo</span>
                            <?php } else { ?>
                                <span class="badge bg-danger rounded-pill">Inactivo</span>
                            <?php } ?>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm" role="group">
                                <a href="permisos.php?idUsuario=<?php echo $registro['ID']; ?>" class="btn btn-sm btn-outline-primary" title="Permisos"><i class="bi bi-key-fill"></i></a>
                                <a href="editar.php?txtID=<?php echo $registro['ID']; ?>" class="btn btn-sm btn-outline-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                <a href="index.php?txtID=<?php echo $registro['ID']; ?>" onclick="return confirm('¿Eliminar usuario?')" class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="bi bi-trash-fill"></i></a>
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