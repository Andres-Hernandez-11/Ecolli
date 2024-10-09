<?php
require_once 'conexion.php'; // Incluye la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Verifica si las contraseñas coinciden
    if ($nueva_contrasena !== $confirmar_contrasena) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Actualiza la contraseña del usuario en la tabla de usuarios
    $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET password = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        echo "Contraseña restablecida con éxito.";
        // Elimina el código de la base de datos si ya no lo necesitas
        $sql_delete = "DELETE FROM password_resets WHERE email = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("s", $email);
        $stmt_delete->execute();
        $stmt_delete->close();
    } else {
        echo "Error al restablecer la contraseña: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Método de solicitud no válido.";
}

$conn->close();
?>
