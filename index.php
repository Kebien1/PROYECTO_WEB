<?php
session_start();
if(isset($_SESSION['usuario_id'])){
    header("Location: modules/usuarios/index.php");
} else {
    // Redirección corregida al nuevo módulo auth
    header("Location: modules/auth/login.php");
}
exit;
?>