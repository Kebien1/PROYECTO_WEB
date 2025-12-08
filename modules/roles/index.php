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
<?php if(isset($_GET['mensaje'])) { ?><div class="alert alert-success"><?php echo $_GET['mensaje']; ?></div><?php } ?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Roles</h4>
        <a class="btn btn-primary" href="crear.php">Nuevo Rol</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark"><tr><th>ID</th><th>Descripción</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach($lista_roles as $registro) { ?>
                <tr>
                    <td><?php echo $registro['ID']; ?></td>
                    <td><?php echo $registro['Descrip']; ?></td>
                    <td>
                        <a class="btn btn-sm btn-info text-white" href="permisos.php?idRol=<?php echo $registro['ID']; ?>">Permisos</a>
                        <a class="btn btn-sm btn-warning" href="editar.php?txtID=<?php echo $registro['ID']; ?>">Editar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>