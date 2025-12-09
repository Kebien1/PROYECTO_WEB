<?php
// Este archivo verifica que el usuario esté logueado
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: " . $base_url . "login.php");
    exit;
}

// Función para verificar si el usuario tiene un permiso específico
function tienePermiso($conexion, $nombrePermiso) {
    if(!isset($_SESSION['usuario_rol'])) return false;
    
    $sentencia = $conexion->prepare("
        SELECT COUNT(*) as total 
        FROM permisos p 
        INNER JOIN detalles d ON p.ID = d.IdPermiso 
        WHERE d.IdRol = :idRol AND p.Descrip = :permiso
    ");
    $sentencia->bindParam(":idRol", $_SESSION['usuario_rol']);
    $sentencia->bindParam(":permiso", $nombrePermiso);
    $sentencia->execute();
    $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
    
    return $resultado['total'] > 0;
}
?>