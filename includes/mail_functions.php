<?php
// Archivo: includes/mail_functions.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/email.php';

// Función genérica de envío
function enviarEmailBase($destinatario, $nombre, $asunto, $cuerpo) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = EMAIL_PORT;
        $mail->CharSet = 'UTF-8';
        
        $mail->setFrom(EMAIL_FROM, 'PrograWeb Sistema');
        $mail->addAddress($destinatario, $nombre);
        
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $cuerpo;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// 1. Para Login con Código (LO QUE PEDISTE)
function enviarCodigoVerificacion($email, $nombre, $codigo) {
    $asunto = "Tu Codigo de Acceso - PrograWeb";
    $mensaje = "
    <div style='font-family: Arial, sans-serif; text-align: center; padding: 20px;'>
        <h2>🔐 Código de Verificación</h2>
        <p>Hola $nombre, usa este código para entrar:</p>
        <h1 style='font-size: 40px; color: #0d6efd; letter-spacing: 5px; margin: 20px 0;'>$codigo</h1>
        <p style='color: #666;'>Si no fuiste tú, cambia tu contraseña.</p>
    </div>
    ";
    return enviarEmailBase($email, $nombre, $asunto, $mensaje);
}

// 2. Para Recuperar Contraseña
function enviarEmailRecuperacion($email, $nombre, $link) {
    $asunto = "Restablecer Contrasena";
    $mensaje = "
    <div style='font-family: Arial, sans-serif; padding: 20px;'>
        <h3>Hola $nombre,</h3>
        <p>Para crear una nueva contraseña, haz clic aquí:</p>
        <p><a href='$link' style='background: #ffc107; color: #000; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Restablecer Contraseña</a></p>
        <p style='font-size: 12px;'>O copia este enlace: $link</p>
    </div>
    ";
    return enviarEmailBase($email, $nombre, $asunto, $mensaje);
}
?>