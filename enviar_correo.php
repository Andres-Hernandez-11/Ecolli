<?php
require_once 'conexion.php'; // Incluye la conexión a la base de datos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que este archivo esté correctamente referenciado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifica si el correo existe en la base de datos
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica si se encontró el usuario
    if ($result->num_rows > 0) {
        // Genera el código de verificación
        $token = rand(100000, 999999); // Código aleatorio de 6 dígitos

        // Aquí puedes agregar la lógica para guardar el código en la base de datos
        $expira = date("Y-m-d H:i:s", strtotime('+10 minutes')); // El código expira en 10 minutos

        $sql_insert = "INSERT INTO password_resets (email, token, expira) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $email, $token, $expira); // Cambia 'codigo' por 'token'

        if ($stmt_insert->execute()) {
            // Configuración de PHPMailer
            $mail = new PHPMailer(true);
            
            try {
                // Configuración del servidor
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'cuentalogin952@gmail.com'; // Tu dirección de correo de Gmail
                $mail->Password = 'dxtp kpaq mkqr grca'; // Tu contraseña de Gmail
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilitar TLS
                $mail->Port = 587; // Puerto para TLS

                // Destinatarios
                $mail->setFrom('cuentalogin952@gmail.com', 'Tu Nombre'); // Cambia por tu nombre
                $mail->addAddress($email); // Dirección de correo del destinatario

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Código de Verificación';
                $mail->Body    = "Tu código de verificación es: <strong>$token</strong>"; // Cambia 'codigo' por 'token'

                $mail->send();

                // Redirige a la página para verificar el código
                header("Location: verificar_codigo.html?email=" . urlencode($email));
                exit();
            } catch (Exception $e) {
                echo "Error al enviar el mensaje: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error al guardar el código en la base de datos: " . $stmt_insert->error;
        }
    } else {
        echo "El correo electrónico no está registrado.";
    }

    $stmt->close();
    $stmt_insert->close();
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
