<?php
// Incluir el archivo de conexión
require_once 'conexion.php';  // Asegúrate de que este archivo está en el mismo directorio

// Inicializar una variable de mensaje vacía
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Preparar y ejecutar la consulta SQL para obtener la contraseña cifrada
    $sql = "SELECT password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si el usuario existe, verificar la contraseña
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            // Login exitoso
            $message = "¡Inicio de sesión exitoso!";
            // Evitar que el formulario cambie de página
            echo "<script>
                alert('$message');
            </script>";
        } else {
            // Contraseña incorrecta
            $message = "Usuario o contraseña incorrectos.";

            // Evitar que el formulario cambie de página
            echo "<script>
                alert('$message');
                window.location.href = 'Login.html';  // Redirige de nuevo a la página de login
            </script>";
        }
    } else {
        // Usuario no encontrado
        $message = "Usuario o contraseña incorrectos.";

        // Evitar que el formulario cambie de página
        echo "<script>
            alert('$message');
            window.location.href = 'Login.html';  // Redirige de nuevo a la página de login
        </script>";
    }

    

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    
}
?>