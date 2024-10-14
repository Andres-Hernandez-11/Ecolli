<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Inicializar una variable de mensaje vacía
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verificar que ambas contraseñas coincidan
    if ($password !== $confirm_password) {
        $message = "Las contraseñas no coinciden. Por favor, inténtalo de nuevo.";

        // Volver a la pagina de Registro
        echo "<script>
            alert('$message');
            window.location.href = 'Registro.html';  // Redirige de nuevo a la página de registro
        </script>";
    } else {
        // Validar la seguridad de la contraseña
        if (!preg_match('/[A-Z]/', $password) || // Al menos una mayúscula
            !preg_match('/[a-z]/', $password) || // Al menos una minúscula
            !preg_match('/[0-9]/', $password) || // Al menos un número
            !preg_match('/[\W]/', $password) ||  // Al menos un carácter especial
            strlen($password) < 8) {             // Longitud mínima de 8 caracteres
            $message = "La contraseña debe tener al menos 8 caracteres, incluyendo una mayúscula, una minúscula, un número y un carácter especial.";

            // Volver a la página de Registro
            echo "<script>
                alert('$message');
                window.location.href = 'Registro.html';  // Redirige de nuevo a la página de registro
            </script>";
        } else {
            // Validar que el usuario tenga más de 18 años
            $birthDate = new DateTime($birthday);
            $today = new DateTime();
            $age = $today->diff($birthDate)->y;

            if ($age < 18) {
                $message = "Debes ser mayor de 18 años para registrarte.";

                // Volver a la pagina de Registro
                echo "<script>
                    alert('$message');
                    window.location.href = 'Registro.html';  // Redirige de nuevo a la página de registro
                </script>";
            } else {
                // Verificar si el correo electrónico ya está registrado
                $checkEmailQuery = "SELECT * FROM usuarios WHERE username = ?";
                $stmt = $conn->prepare($checkEmailQuery);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $message = "El correo electrónico ya está registrado.";

                    // Volver a la pagina de Registro
                    echo "<script>
                        alert('$message');
                        window.location.href = 'Registro.html';  // Redirige de nuevo a la página de registro
                    </script>";
                } else {
                    // Cifrar la contraseña antes de almacenarla
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insertar los datos en la base de datos
                    $insertQuery = "INSERT INTO usuarios (name, birthday, username, password) VALUES (?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bind_param("ssss", $name, $birthday, $username, $hashed_password);

                    if ($stmt->execute()) {
                        $message = "Usuario registrado con éxito.";

                        // Volver a la página de login
                        echo "<script>
                            alert('$message');
                            window.location.href = 'Login.html';  // Redirige de nuevo a la página de Login
                        </script>";
                    } else {
                        $message = "Error al registrar el usuario: " . $conn->error;

                        // Volver a la pagina de Registro
                        echo "<script>
                            alert('$message');
                            window.location.href = 'Registro.html';  // Redirige de nuevo a la página de registro
                        </script>";
                    }
                }
                $stmt->close();
            }
        }
    }
    $conn->close();
}
?>
