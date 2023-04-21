<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Mailer/src/Exception.php';
require 'Mailer/src/PHPMailer.php';
require 'Mailer/src/SMTP.php';

$mail = new PHPMailer;
$mail->SMTPDebug = 0; 
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.gmail.com'; // Cambia esto con el host de tu servidor de correo saliente
$mail->Port = 587; // Cambia esto con el puerto de tu servidor de correo saliente
$mail->Username = 'opseliperu@gmail.com'; // Cambia esto con tu dirección de correo electrónico
$mail->Password = 'HHvv97531--=='; // Cambia esto con tu contraseña de correo electrónico
$mail->CharSet = 'UTF-8';   


// Obtén los datos del formulario
$nombre = $_POST['Nombre'];
$correo = $_POST['Correo'];
$numero = $_POST['Numero'];
$mensaje = $_POST['Mensaje'];

// Configura el remitente y destinatario del correo
$mail->setFrom('opseliperu@gmail.com', 'OPSELI WEB');
$mail->addAddress('mpacheco.tacay@gmail.com', 'OPSELI');
// $mail->addCC('copia@example.com', 'Nombre de la Copia');

// Configura el contenido del correo
$mail->Subject = 'Formulario de contacto';
$mail->Body = "Nombre: $nombre\nCorreo: $correo\nN° Celular: $numero\nMensaje: $mensaje";

// Envía el correo
if ($mail->send()) {
    // Si se envía exitosamente, puedes realizar acciones adicionales, como redirigir a una página de confirmación
    echo '¡Correo enviado con éxito!';
} else {
    // Si hay un error en el envío, puedes mostrar un mensaje de error o realizar acciones de manejo de errores
    echo 'Error al enviar el correo: ' . $mail->ErrorInfo;
}

?>
