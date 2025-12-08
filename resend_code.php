<?php
// Archivo: resend_code.php
session_start();
include("config/bd.php");

if(!isset($_SESSION['email_verificacion'])){
    header("Location: register.php");
    exit;
}

// Generar nuevo código
$codigo_verificacion = sprintf("%06d", mt_rand(1, 999999));
$_SESSION['codigo_verificacion'] = $codigo_verificacion;

$email = $_SESSION['email_verificacion'];

// Enviar email
$asunto = "Nuevo Código de Verificación - PrograWeb";
$mensaje = "
<html>
<head><title>Nuevo Código de Verificación</title></head>
<body>
    <h2>Nuevo Código de Verificación</h2>
    <p>Has solicitado un nuevo código de verificación.</p>
    <h1 style='color: #007bff; font-size: 32px;'>$codigo_verificacion</h1>
    <p>Ingresa este código para activar tu cuenta.</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: PrograWeb <noreply@prograweb.com>\r\n";

if(mail($email, $asunto, $mensaje, $headers)){
    header("Location: verify.php?mensaje=Código reenviado");
} else {
    header("Location: verify.php?error=No se pudo reenviar el código");
}
exit;
?>