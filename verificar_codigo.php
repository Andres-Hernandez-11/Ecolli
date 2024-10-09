<?php
require_once 'conexion.php'; // Incluye la conexión a la base de datos

//inicializar variables
$message = "";
$mail ="";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];          // Obtén el correo electrónico
    $codigo_ingresado = $_POST['codigo']; // Obtén el código ingresado

    // Verifica el código en la base de datos
    $sql = "SELECT * FROM password_resets WHERE email = ? AND token = ? AND expira > NOW()";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $codigo_ingresado);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Código verificado con éxito. Ahora puedes restablecer tu contraseña.";
        // Aquí rediriges a la página para restablecer la contraseña
        header("Location: restablecer_contraseña.html?email=" . urlencode($email));
        exit();
    } else {
        $message = "El código o el correo electrónico son incorrectos o han expirado.";

            // Volver a la pagina de Registro
            echo "<script>
                alert('$message');
                window.location.href = 'verificar_codigo.html';  // Redirige de nuevo a la página de Verficar codigo
            </script>";
    }

    $stmt->close();
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
