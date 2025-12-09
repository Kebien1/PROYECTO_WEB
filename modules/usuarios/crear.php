<?php 
include("../../config/bd.php"); 

// Obtener roles
$sqlRoles = $conexion->prepare("SELECT * FROM rol");
$sqlRoles->execute();
$roles = $sqlRoles->fetchAll(PDO::FETCH_ASSOC);

if($_POST){
    // ... (Tu lógica PHP de guardado se mantiene igual) ...
    $usuario = $_POST["Nick"] ?? "";
    $clave   = $_POST["Password"] ?? "";
    $Email   = $_POST["Email"] ?? "";
    $IdRol   = $_POST["IdRol"] ?? "";
    $estado  = $_POST["Estado"] ?? "";

    if($usuario && $clave && $Email) {
        $sentencia = $conexion->prepare("INSERT INTO usuario(Nick,Password,Email,Estado,IdRol) VALUES (:Nick,:Password,:Email,:Estado,:IdRol)");
        $sentencia->bindParam(":Nick", $usuario);
        $sentencia->bindParam(":Password", $clave);
        $sentencia->bindParam(":Email", $Email);
        $sentencia->bindParam(":Estado", $estado);
        $sentencia->bindParam(":IdRol", $IdRol);
        $sentencia->execute();
        header("Location:index.php?mensaje=Usuario creado");
        exit;
    }
}
include("../../includes/header.php");
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Usuario</h5>
            </div>
            <div class="card-body p-4">
                <form action="" method="post">
                    
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nick" name="Nick" placeholder="Nombre" required>
                        <label for="nick">Nombre de Usuario</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="Email" placeholder="Correo" required>
                        <label for="email">Correo Electrónico</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="pass" name="Password" placeholder="Clave" required>
                        <label for="pass">Contraseña</label>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="IdRol" class="form-select" id="rol" required>
                                    <option value="">Seleccione...</option>
                                    <?php foreach($roles as $rol) { ?>
                                        <option value="<?php echo $rol['ID']; ?>"><?php echo $rol['Descrip']; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="rol">Rol</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <select name="Estado" class="form-select" id="estado" required>
                                    <option value="1">ACTIVO</option>
                                    <option value="0">INACTIVO</option>
                                </select>
                                <label for="estado">Estado</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("../../includes/footer.php"); ?>