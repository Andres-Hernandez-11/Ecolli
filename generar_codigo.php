<?php
require_once 'conexion.php'; // Incluye la conexión a la base de datos

header('Content-Type: text/html; charset=utf-8'); // Establecer la codificación

// Inicializar variables
$message = "";
$mail = "";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifica si el correo existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Genera un código aleatorio de 6 dígitos
        $codigo = rand(100000, 999999);

        // Envía el código al correo electrónico
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'cuentalogin952@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password = 'dxtp kpaq mkqr grca'; // Tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatarios
            $mail->setFrom('cuentalogin952@gmail.com', 'E. COLLI ALERT');
            $mail->addAddress($email);

            // Contenido
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8'; // Establecer codificación a UTF-8
            $mail->Subject = 'Código de Verificación';
            $mail->Body    = '<html>
                                <body>
                                    <h2>Código de Verificación</h2>
                                    <p>Tu código de verificación es: <strong>' . $codigo . '</strong></p>
                                </body>
                              </html>';

            $mail->send();

            // Guarda el código en la base de datos con una fecha de expiración
            $expira = date('Y-m-d H:i:s', strtotime('+10 minutes')); // El código expira en 10 minutos
            $sql_insert = "INSERT INTO password_resets (email, token, expira) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("sss", $email, $codigo, $expira);
            $stmt_insert->execute();

            $message = "El código ha sido enviado a tu correo";

            // Volver a la pagina de Verificación de código
            echo "<script>
                alert('$message');
                window.location.href = 'verificar_codigo.html';  // Redirige a la página de verificación
            </script>";
        } catch (Exception $e) {
            $message = "Error al enviar el mensaje: " . $mail->ErrorInfo;

            // Volver a la pagina de Login
            echo "<script>
                alert('$message');
                window.location.href = 'Login.html';  // Redirige a la página de login
            </script>";
        }
    } else {
        $message = "El correo electrónico no está registrado";

        // Volver a la pagina de Login
        echo "<script>
            alert('$message');
            window.location.href = 'Login.html';  // Redirige a la página de login
        </script>";
    }

    $stmt->close();
} else {
    $message = "Método de solicitud no válido";

    // Volver a la pagina de Login
    echo "<script>
        alert('$message');
        window.location.href = 'Login.html';  // Redirige a la página de login
    </script>";
}

$conn->close();
?>
