<?php
session_start();

// Verificar si la sesión está activa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirigir al login
    header("Location: Login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Síntomas de E. coli</title>
    <link rel="stylesheet" href="Estilos_RegistrarSintomas.css">
</head>
<body>

    <nav class="nav-superior">
        <a href="informacion.php"> <!-- Reemplaza con la URL deseada -->
                <img src="IMAGES/LogoEcolli.jpg" alt="Logo" class="logo"> <!-- Reemplaza logo.png con la ruta de tu imagen -->
        </a>
    </nav>
    <!-- Navegación principal -->
    <nav class="nav-principal">
        <ul>
            <li><a href="informacion.php">Inicio</a></li>
            <li><a href="Mapa.php">Mapa</a></li>
            <li><a href="registrarSintomas.php">Registrar Síntomas</a></li>
            <li class="logout-container"><a href="logout.php" class="logout-btn">Cerrar sesión</a></li> 
        </ul>
    </nav>

    <div class="container">
        <h1>Encuesta de Síntomas de E. coli</h1>
        <form id="encuestaForm">
            <p><strong>Por favor, complete la siguiente encuesta para evaluar síntomas relacionados con E. coli.</strong></p>

            <!-- Temperatura corporal -->
            <fieldset>
                <legend>Temperatura corporal</legend>
                <label for="temperatura">Ingrese su temperatura actual (°C):</label>
                <input type="number" id="temperatura" min="35" max="42" step="0.1" placeholder="Ejemplo: 38.5">
            </fieldset>

            <!-- Síntomas característicos de E. coli -->
            <fieldset>
                <legend>Síntomas principales</legend>
                <label>
                    <input type="checkbox" name="sintoma" value="nausea"> Náuseas
                </label><br>
                <label>
                    <input type="checkbox" name="sintoma" value="vomito"> Vómitos
                </label><br>
                <label>
                    <input type="checkbox" name="sintoma" value="dolor_estomacal"> Dolor abdominal
                </label><br>
                <label>
                    <input type="checkbox" name="sintoma" value="diarrea"> Diarrea
                </label><br>
                <label>
                    <input type="checkbox" name="sintoma" value="diarrea_sangre"> Diarrea con sangre
                </label>
            </fieldset>

            <!-- Duración de síntomas -->
            <fieldset>
                <legend>Duración de los síntomas</legend>
                <label for="duracionSintomas">Número de días con síntomas:</label>
                <input type="number" id="duracionSintomas" placeholder="Ejemplo: 3" min="1">
            </fieldset>

            <!-- Severidad de los síntomas -->
            <fieldset>
                <legend>Severidad de los síntomas</legend>
                <label>
                    <input type="radio" name="severidad" value="leve"> Leve
                </label>
                <label>
                    <input type="radio" name="severidad" value="moderado"> Moderado
                </label>
                <label>
                    <input type="radio" name="severidad" value="severo"> Severo
                </label>
            </fieldset>

            <button type="button" onclick="calcularRiesgo()">Calcular Riesgo de Contagio</button>
        </form>
        
        <p id="resultado"></p>

            <button id="ubicacionButton" type="button" onclick="compartirUbicacion()" style="display: none;">Permitir compartir ubicación</button>

  

            


    </div>
    <script src="script.js"></script>
</body>
</html>
