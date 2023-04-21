<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Mailer/src/Exception.php';
require 'Mailer/src/PHPMailer.php';
require 'Mailer/src/SMTP.php';


// Configurar los detalles del correo electrónico
$mail = new PHPMailer(true);
try {

    //Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP(); //Send using SMTP
    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
    $mail->SMTPAuth = true; //Enable SMTP authentication
    $mail->Username = 'mpacheco.tacay@gmail.com'; //SMTP username
    $mail->Password = 'avmsnsjpyyfppuot'; //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->CharSet = 'UTF-8'; //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    // $mail->setFrom('reportes.petrothor@gmail.com', 'Reportes Petrothor');   //Add a recipient
    $mail->addAddress('mpacheco.tacay@gmail.com'); //Add a recipient

    // $mail->addReplyTo('reportes.petrothor@gmail.com', 'Reportes Petrothor');
// Obtén los datos del formulario
    $nombre = $_POST['Nombre'];
    $correo = $_POST['Correo'];
    $numero = $_POST['Numero'];
    $mensaje = $_POST['Mensaje'];
    //Content
    $mail->isHTML(true);
    // Configura el contenido del correo
    $mail->Subject = 'Solicitud de cotización OPSELI.COM';
    $mail->Body = "
    <h2 style='text-decoration: none;'>Formulario de contacto de la web OPSELI</h2>
    <p>Saludos, estoy interesad@ en los servicios que ofrecen, le brindo mis datos.</p>
    <p><strong>Nombre:</strong> $nombre</p>
    <p><strong>Correo:</strong> $correo</p>
    <p><strong>N° Celular:</strong> $numero</p>
    <p><strong>Mensaje:</strong> $mensaje</p>
";


    if (!isset($_POST)) {

        die('No autorizado');
    }

    function json_output($status = 200, $msg = 'OK', $data = [])
    {
        echo json_encode(['status' => $status, 'msg' => $msg, 'data' => $data]);
        die;
    }

    $mail->send();
    echo "El correo electrónico ha sido enviado exitosamente.";
    error_log('El script se ha ejecutado correctamente');

} catch (Exception $e) {
    echo "Hubo un error al enviar el correo electrónico: {$mail->ErrorInfo}";
}

?>