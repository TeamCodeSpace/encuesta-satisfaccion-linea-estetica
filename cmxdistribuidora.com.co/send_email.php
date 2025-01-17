<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Configuración de la base de datos
define('DB_NAME', 'cmxdistribuidora_com_co_1');
define('DB_USER', 'kb7rp8qk');
define('DB_PASSWORD', '5TeQu3S!');
define('DB_HOST', 'mysql.cmxdistribuidora.com.co');

// Configuración de correo
define('WPMS_MAIL_FROM', 'no-reply@lineaestetica.co');
define('WPMS_MAIL_FROM_NAME', 'Línea Estética, Somos tu market de bienestar');
define('WPMS_SMTP_HOST', 'smtp.mandrillapp.com');
define('WPMS_SMTP_PORT', 587);
define('WPMS_SSL', 'tls');
define('WPMS_SMTP_AUTH', true);
define('WPMS_SMTP_USER', 'CMX S.A.S');
define('WPMS_SMTP_PASS', 'md-q5EyO3unRJGIQXZ4bHDLEA');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanitizar la entrada
    $nombre = htmlspecialchars(trim($_POST['nombre']), ENT_QUOTES, 'UTF-8');
    $documento_identidad = htmlspecialchars(trim($_POST['documento_identidad']), ENT_QUOTES, 'UTF-8');
    $punto_venta = htmlspecialchars(trim($_POST['punto_venta']), ENT_QUOTES, 'UTF-8');
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars(trim($_POST['telefono']), ENT_QUOTES, 'UTF-8');
    $ratingArray = isset($_POST['rating']) ? $_POST['rating'] : [];

    // Determinar la calificación final basada en el valor máximo del array
    $rating = !empty($ratingArray) ? max($ratingArray) : 0;

    $sugerencias = htmlspecialchars(trim($_POST['sugerencias']), ENT_QUOTES, 'UTF-8');
    $nuevocampo = isset($_POST['nuevocampo']) ? htmlspecialchars(trim($_POST['nuevocampo']), ENT_QUOTES, 'UTF-8') : 'No especificado';
    $acepto = isset($_POST['acepto']) ? 1 : 0;

    // Crear conexión
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Insertar datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO encuestas (nombre, documento_identidad, punto_venta, email, telefono, rating, sugerencias, nuevocampo, acepto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    if (!$stmt->bind_param("ssssssssi", $nombre, $documento_identidad, $punto_venta, $email, $telefono, $rating, $sugerencias, $nuevocampo, $acepto)) {
        die("Error en la vinculación de parámetros: " . $stmt->error);
    }

    if (!$stmt->execute()) {
        die("Error al insertar datos: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    // Configuración del correo para enviar datos al administrador
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = WPMS_SMTP_HOST;
        $mail->SMTPAuth = WPMS_SMTP_AUTH;
        $mail->Username = WPMS_SMTP_USER;
        $mail->Password = WPMS_SMTP_PASS;
        $mail->SMTPSecure = WPMS_SSL;
        $mail->Port = WPMS_SMTP_PORT;

        $mail->setFrom(WPMS_MAIL_FROM, WPMS_MAIL_FROM_NAME);
        $mail->addAddress('darwincanas16@gmail.com');
        // $mail->addAddress('jftoro8@gmail.com');
        // $mail->addAddress('sig@lineaestetica.co');
        // $mail->addAddress('gerente.ejecutiva@lineaestetica.co');
        // $mail->addAddress('pqr@lineaestetica.co');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Nueva Encuesta Completada';
        $mail->Body = "
        <table width=\"100%\" border=\"0\" align=\"center\">
        <tbody>
            <tr>
                <td>
                    <table width=\"600\" border=\"0\" align=\"center\">
                        <tbody>
                            <tr>
                                <td><img src=\"https://www.esteticadrop.com/img/Logo-Linena-Estetica-2023.webp\" width=\"70%\" alt=\"\"/></td>
                            </tr>
                            <tr>
                                <td><h2 style=\"color: #422962; font-family: Segoe, 'Segoe UI', Verdana;\">Detalles de la Encuesta</h2></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Nombre:</strong> $nombre</p>
                                    <p><strong>Documento de Identidad:</strong> $documento_identidad</p>
                                    <p><strong>Punto de Venta:</strong> $punto_venta</p>
                                    <p><strong>Email:</strong> $email</p>
                                    <p><strong>Teléfono:</strong> $telefono</p>
                                    <p><strong>Calificación:</strong> $rating estrellas</p>
                                    <p><strong>¿Qué nos hace diferentes?:</strong> $nuevocampo</p>
                                    <p><strong>Sugerencias:</strong> $sugerencias</p>
                                    <p><strong>Aceptó términos:</strong> " . ($acepto ? 'Sí' : 'No') . "</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
        </table>";

        $mail->send();

        $mail->clearAddresses();
        $mail->addAddress($email, $nombre);
        $mail->Subject = '💜 Tu Bienestar es nuestro bienestar 💜';
        $mail->Body = "
            <html>
            <body>
                <p>Estimado/a $nombre,</p>
                <img src='https://dev.lineaestetica.co/img/tarjeta-agradecimiento-lineaestetica.jpg' alt='Gracias'>
                <p>Saludos,<br>Equipo de Línea Estética</p>
            </body>
            </html>";

        $mail->send();
        header("Location: index.html");
        exit();
    } catch (Exception $e) {
        error_log('el email no se puedo enviar');
    }
    
}
?>
