<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Mailer/src/Exception.php';
require 'Mailer/src/PHPMailer.php';
require 'Mailer/src/SMTP.php';

//OBTENER EID DE WIALON


$url = 'https://hst-api.wialon.com/wialon/ajax.html?svc=token/login&params={"token":"c28cceaa24ae60f0b2e3459d2062f37f361080E9DA39EFE53663856A6E0501EFCCD43045","fl":"2"}';
$response = file_get_contents($url);
$data = json_decode($response, true);
$eid = $data['eid'];
// echo $eid;


//OBTENER LISTAS DE UNIDADES LDROJAS

$params = array(
    "spec" => array(
        "itemsType" => "avl_unit",
        "propName" => "sys_name",
        "propValueMask" => "*",
        "sortType" => "sys_name",
        "propType" => "propitemname"
    ),
    "force" => 1,
    "flags" => 9217,
    "from" => 0,
    "to" => 0
);

$url = "https://hst-api.wialon.com/wialon/ajax.html?svc=core/search_items&params=" . urlencode(json_encode($params)) . "&sid=" . $eid;

$result = file_get_contents($url);
// echo $result;

// SENDATA WIALON
$data = json_decode($result, true);

$superArray = array();
$superArrayLog = array();
// print_r($data);
foreach ($data["items"] as $f) {
    // echo $f;
    //FECHA
    $tempFechaw = intval($f["pos"]["t"]) - 18000;
    $tempFecha = gmdate('Y-m-d H:i:00', $tempFechaw);

    //PLACA
    $tempPlaca = str_replace(array(" ", "-"), "", $f["nm"]);
    $tempPlaca = substr($tempPlaca, 0, 6);
    // echo print_r($tempPlaca) . "\n";
    array_push($superArray, $tempPlaca);
}

//SEND CORREO SIGNIA
$url = 'http://signianet.com:93/Pedido/ListarPedido';
$result = file_get_contents($url);
$json_result = json_decode($result, true);
$listPlacas = [];

foreach ($superArray as $placasSignia) {
    foreach ($json_result as $item) {
        if ($item['PLACA'] == $placasSignia) {
            // echo $item['PLACA'] . "\n";
            $listPlacas[] = $item['PLACA'];
        }
    }
}

$parsedPlacas = array_unique($listPlacas);

print_r($parsedPlacas);



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


    // Obtén los datos del formulario
    $nombre = $_POST['Nombre'];
    $correo = $_POST['Correo'];
    $numero = $_POST['Numero'];
    $mensaje = $_POST['Mensaje'];

    //Recipients
    // $mail->setFrom('reportes.petrothor@gmail.com', 'Reportes Petrothor');   //Add a recipient
    $mail->addAddress('mpacheco.tacay@gmail.com'); //Add a recipient

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
}
?>