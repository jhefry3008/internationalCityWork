<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipoCliente = $_POST['tipo_cliente']; // Asegúrate de que este campo esté en el formulario

    // Datos comunes
    $empresaEmail = "jhefryherrera3008@gmail.com";

    // Inicializa las variables
    $empresa = $nit = $direccion = $ciudad = $telefono = $email = $mensaje =
        $librosSeleccionados = "";
    $metodoPago = "";
    $totalAPagar = "";

    // Lógica para cada tipo de cliente
    if ($tipoCliente === 'juridica') {
        $empresa = htmlspecialchars($_POST['Empresa']);
        $nit = htmlspecialchars($_POST['nit']);
        $direccion = htmlspecialchars($_POST['Direccion']);
        $ciudad = htmlspecialchars($_POST['Ciudad']);
        $telefono = htmlspecialchars($_POST['Telefono']);
        $email = htmlspecialchars($_POST['Correo']);
        $mensaje = htmlspecialchars($_POST['Mensaje']);
        $librosSeleccionados = htmlspecialchars($_POST['Libros']);
        $metodoPago = htmlspecialchars($_POST['paymentMethod']);
        $totalAPagar = htmlspecialchars($_POST['totalToPay']);
        $asunto = "Comprobante de compra para $empresa";

        // Convertir libros seleccionados en array y crear lista HTML
        $librosArray = explode(",", $librosSeleccionados);
        $listaLibrosHTML = "<ul>";
        foreach ($librosArray as $libro) {
            $listaLibrosHTML .= "<li>" . trim($libro) . "</li>";
        }
        $listaLibrosHTML .= "</ul>";

        // Cuerpo del correo
        $mensajeCorreo = "
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Factura</title>
</head>
<body>
    <h2>Gracias por tu compra, $empresa</h2>
    <p>Comprobante de compra:</p>
    <ul>
        <li><strong>Nombre de la Empresa:</strong> $empresa</li>
        <li><strong>NIT:</strong> $nit</li>
        <li><strong>Dirección:</strong> $direccion</li>
        <li><strong>Ciudad:</strong> $ciudad</li>
        <li><strong>Teléfono:</strong> $telefono</li>
        <li><strong>Email:</strong> $email</li>
        <li><strong>Mensaje:</strong> $mensaje</li>
         <li><strong>Libros Seleccionados:</strong> $listaLibrosHTML</li> <!-- Lista de libros -->
        <li><strong>Total a Pagar: $ </strong> $totalAPagar</li>
        <li><strong>Método de Pago:</strong> $metodoPago</li>
       
    </ul>
    <h2 style='text-align: center;'>Gracias por confiar en nosotros,nos pondremos en contacto con usted</h2>
</body>
</html>
        ";
    } elseif ($tipoCliente === 'Natural') {
        $nombre = htmlspecialchars($_POST['Nombre_Completo']);
        $documento = htmlspecialchars($_POST['tipo-documento']);
        $numero = htmlspecialchars($_POST['numero-documento']);
        $direccion = htmlspecialchars($_POST['Direccion']);
        $ciudad = htmlspecialchars($_POST['Ciudad']);
        $telefono = htmlspecialchars($_POST['Telefono']);
        $email = htmlspecialchars($_POST['Correo']);
        $mensaje = htmlspecialchars($_POST['Mensaje']);
        $librosSeleccionados = htmlspecialchars($_POST['Libros']);
        $totalAPagar = htmlspecialchars($_POST['totalToPay']);
        $metodoPago = htmlspecialchars($_POST['paymentMethod']);

        $asunto = "Comprobante de compra para $nombre";

        // Convertir libros seleccionados en array y crear lista HTML
        $librosArray = explode(",", $librosSeleccionados);
        $listaLibrosHTML = "<ul>";
        foreach ($librosArray as $libro) {
            $listaLibrosHTML .= "<li>" . trim($libro) . "</li>";
        }
        $listaLibrosHTML .= "</ul>";

        // Cuerpo del correo
        $mensajeCorreo = "
        <!DOCTYPE html>
        <html lang='es'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Factura</title>
        </head>
        <body>
            <h2>Gracias por tu compra, $nombre</h2>
            <p>Comprobante de compra:</p>
            <ul>
                <li><strong>Nombre:</strong> $nombre</li>
                <li><strong>Tipo de Documento:</strong> $documento</li>
                <li><strong>Numero:</strong> $numero</li>
                <li><strong>Dirección:</strong> $direccion</li>
                <li><strong>Ciudad:</strong> $ciudad</li>
                <li><strong>Teléfono:</strong> $telefono</li>
                <li><strong>Email:</strong> $email</li>
                <li><strong>Mensaje:</strong> $mensaje</li>
                <li><strong>Libros Seleccionados:</strong> $listaLibrosHTML</li> <!-- Lista de libros -->
                <li><strong>Total a Pagar: $ </strong> $totalAPagar</li>
                <li><strong>Método de Pago:</strong> $metodoPago</li>
                
            </ul>
            <h2 style='text-align: center;'>Gracias por confiar en nosotros,nos pondremos en contacto con usted</h2>
        </body>
        </html>
        ";
    } else {
        echo "Tipo de cliente no válido.";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'jhefryherrera3008@gmail.com'; // Tu dirección de correo Gmail
        $mail->Password = 'unoj lvvw mcbo dagj'; // Reemplaza con la contraseña de aplicación correcta
        $mail->SMTPSecure = 'tls'; // Habilitar cifrado TLS
        $mail->Port = 587; // Puerto de SMTP de Gmail

        // Enviar correo al usuario
        $mail->setFrom('jhefryherrera3008@gmail.com', 'International City Work');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensajeCorreo;
        $mail->send();

        // Enviar correo a la empresa
        $mail->clearAddresses();
        $mail->addAddress($empresaEmail);
        $mail->addReplyTo($email, 'Responder al cliente'); // Añadir dirección de respuesta
        $mail->Subject = $asunto;
        $mail->Body = $mensajeCorreo;
        $mail->send();

        header("Location: ../index.html");
        exit();
    } catch (Exception $e) {
        echo "El correo no se pudo enviar. Error: {$mail->ErrorInfo}";
    }
}
