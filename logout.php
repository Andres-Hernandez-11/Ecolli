<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
$_SESSION = array();  // Vaciar las variables de la sesión
session_destroy();  // Destruir la sesión

// Redirigir a la página de login u otra página
header("Location: Login.html");
exit;
?>
