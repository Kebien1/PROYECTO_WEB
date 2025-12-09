<?php
// Archivo: modules/auth/logout.php
session_start();
session_destroy();
// Redirección directa porque login.php está en la misma carpeta
header("Location: login.php");
exit;
?>