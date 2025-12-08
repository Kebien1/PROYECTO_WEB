<?php
// Archivo: config/email.php

// ===== CONFIGURACIÓN GMAIL =====
define('EMAIL_HOST', 'smtp.gmail.com');
define('EMAIL_PORT', 587);
define('EMAIL_USERNAME', 'colombiamasterg@gmail.com'); // ⚠️ CAMBIAR
define('EMAIL_PASSWORD', 'zzpz wehx kbnw mqek'); // ⚠️ Tu contraseña de aplicación
define('EMAIL_FROM', 'colombiamasterg@gmail.com'); // ⚠️ CAMBIAR
define('EMAIL_FROM_NAME', 'PrograWeb Sistema');

// ===== CONFIGURACIÓN MAILTRAP (Para desarrollo) =====
// Descomenta estas líneas si usas Mailtrap
/*
define('EMAIL_HOST', 'sandbox.smtp.mailtrap.io');
define('EMAIL_PORT', 2525);
define('EMAIL_USERNAME', 'tu_usuario_mailtrap'); // ⚠️ CAMBIAR
define('EMAIL_PASSWORD', 'tu_password_mailtrap'); // ⚠️ CAMBIAR
define('EMAIL_FROM', 'noreply@prograweb.com');
define('EMAIL_FROM_NAME', 'PrograWeb Sistema');
*/
?>