<?php
// Archivo: includes/mail_functions.php
//

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/email.php';

function enviarEmail($destinatario, $nombre_destinatario, $asunto, $mensaje_html) {
    $mail = new PHPMailer(true);
    
    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = EMAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = EMAIL_USERNAME;
        $mail->Password = EMAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = EMAIL_PORT;
        $mail->CharSet = 'UTF-8';
        
        // Remitente
        $mail->setFrom(EMAIL_FROM, EMAIL_FROM_NAME);
        
        // Destinatario
        $mail->addAddress($destinatario, $nombre_destinatario);
        
        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje_html;
        
        // Enviar
        $mail->send();
        return true;
        
    } catch (Exception $e) {
        error_log("Error al enviar email: {$mail->ErrorInfo}");
        return false;
    }
}

// Función específica para código de verificación
function enviarCodigoVerificacion($email, $nombre, $codigo, $tipo = 'registro') {
    $asunto = ($tipo == 'registro') 
        ? "Código de Verificación - PrograWeb" 
        : "Código de Acceso - PrograWeb";
    
    $mensaje = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
            .container { background-color: white; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 5px; text-align: center; }
            .codigo { font-size: 36px; font-weight: bold; color: #667eea; text-align: center; padding: 20px; background-color: #f8f9fa; border-radius: 5px; margin: 20px 0; letter-spacing: 5px; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>🔐 PrograWeb</h1>
                <p>" . ($tipo == 'registro' ? 'Verificación de Cuenta' : 'Código de Acceso') . "</p>
            </div>
            <p>Hola <strong>$nombre</strong>,</p>
            <p>Tu código de verificación es:</p>
            <div class='codigo'>$codigo</div>
            <p style='text-align: center; color: #666;'>Este código es válido por 15 minutos</p>
            <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
            <div class='footer'>
                <p>Este es un correo automático, por favor no responder.</p>
                <p>&copy; 2024 PrograWeb - Sistema de Gestión</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return enviarEmail($email, $nombre, $asunto, $mensaje);
}

// --- NUEVA FUNCIÓN AGREGADA PARA RECUPERACIÓN ---
function enviarEmailRecuperacion($email, $nombre, $link) {
    $asunto = "Recuperar Contraseña - PrograWeb";
    
    $mensaje = "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px; }
            .container { background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
            .header { text-align: center; border-bottom: 2px solid #ffc107; padding-bottom: 20px; margin-bottom: 20px; }
            .btn { background-color: #ffc107; color: #000; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block; margin-top: 20px; }
            .footer { margin-top: 30px; font-size: 12px; color: #6c757d; text-align: center; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2 style='margin:0;'>🔐 Recuperación de Cuenta</h2>
            </div>
            <p>Hola <strong>$nombre</strong>,</p>
            <p>Hemos recibido una solicitud para restablecer tu contraseña.</p>
            <p>Haz clic en el botón para continuar:</p>
            
            <div style='text-align: center; margin: 30px 0;'>
                <a href='$link' class='btn'>Restablecer Contraseña</a>
            </div>
            
            <p style='color: #666; font-size: 14px;'>Este enlace es válido por 1 hora.</p>
            <div class='footer'>PrograWeb Sistema</div>
        </div>
    </body>
    </html>
    ";
    
    return enviarEmail($email, $nombre, $asunto, $mensaje);
}
?>