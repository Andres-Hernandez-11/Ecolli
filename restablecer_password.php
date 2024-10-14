<?php
require_once 'conexion.php'; // Incluye la conexión a la base de datos

// Inicializar variables
$message = "";
$mail = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verifica si las contraseñas coinciden
    if ($nueva_contrasena !== $confirmar_contrasena) {
        $message = "Las contraseñas no coinciden";

        echo "<script>
            alert('$message');
            window.location.href = 'restablecer_contraseña.html';  // Redirige de nuevo a la página de restablecer contraseña
        </script>";
        exit;
    }

    // Validar la seguridad de la nueva contraseña
    if (!preg_match('/[A-Z]/', $nueva_contrasena) || // Al menos una mayúscula
        !preg_match('/[a-z]/', $nueva_contrasena) || // Al menos una minúscula
        !preg_match('/[0-9]/', $nueva_contrasena) || // Al menos un número
        !preg_match('/[\W]/', $nueva_contrasena) ||  // Al menos un carácter especial
        strlen($nueva_contrasena) < 8) {             // Longitud mínima de 8 caracteres
        $message = "La nueva contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial.";

        echo "<script>
            alert('$message');
            window.location.href = 'restablecer_contraseña.html';  // Redirige de nuevo a la página de restablecer contraseña
        </script>";
        exit;
    }

    // Verifica si el usuario existe
    $sql_check = "SELECT * FROM usuarios WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // El usuario existe, procedemos a actualizar la contraseña
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            // Elimina el código de la base de datos si ya no lo necesitas
            $sql_delete = "DELETE FROM password_resets WHERE email = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param("s", $email);
            $stmt_delete->execute();
            $stmt_delete->close();

            $message = "Contraseña restablecida con éxito";

            echo "<script>
                alert('$message');
                window.location.href = 'Login.html';  // Redirige de nuevo a la página de Login
            </script>";
        } else {
            $message = "Error al restablecer la contraseña";

            echo "<script>
                alert('$message');
                window.location.href = 'restablecer_contraseña.html';  // Redirige de nuevo a la página de restablecer contraseña
            </script>";
        }
    } else {
        $message = "El usuario no existe";

        echo "<script>
            alert('$message');
            window.location.href = 'restablecer_contraseña.html';  // Redirige de nuevo a la página de restablecer contraseña
        </script>";
    }

    $stmt_check->close();
} else {
    $message = "Método de solicitud no válido";

    echo "<script>
        alert('$message');
        window.location.href = 'restablecer_contraseña.html';  // Redirige de nuevo a la página de restablecer contraseña
    </script>";
}

$conn->close();
?>
