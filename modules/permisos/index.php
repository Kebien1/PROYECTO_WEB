<?php 
include("../../config/bd.php");
if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia=$conexion->prepare("DELETE FROM permisos WHERE ID=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    header("Location:index.php?mensaje=Eliminado"); exit;
}
$sentencia=$conexion->prepare("SELECT * FROM permisos");
$sentencia->execute();
$lista_permisos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
include("../../includes/header.php");
?>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>Permisos</h4>
        <a class="btn btn-primary" href="crear.php">Nuevo</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-dark"><tr><th>ID</th><th>Permiso</th><th>Acciones</th></tr></thead>
            <tbody>
                <?php foreach($lista_permisos as $registro) { ?>
                <tr>
                    <td><?php echo $registro['ID']; ?></td>
                    <td><?php echo $registro['Descrip']; ?></td>
                    <td>
                        <a class="btn btn-sm btn-warning" href="editar.php?txtID=<?php echo $registro['ID']; ?>">Editar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>