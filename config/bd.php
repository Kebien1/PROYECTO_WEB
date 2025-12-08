<?php
// Archivo: config/bd.php
$servidor = "localhost";
$basededatos = "prograweb";
$usuario = "root";
$clave = "";

// RUTA BASE: Ajusta "actividad_1" si tu carpeta tiene otro nombre en htdocs
$base_url = "http://localhost/actividad_1/";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$basededatos", $usuario, $clave);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $ex) {
    echo "Error de conexión: " . $ex->getMessage();
}
?>