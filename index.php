<?php
// Archivo: index.php
session_start();
if(isset($_SESSION['usuario_id'])){
    header("Location: modules/usuarios/index.php");
} else {
    header("Location: login.php");
}
exit;
?>