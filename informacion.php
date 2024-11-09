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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bacteria E.Colli</title>
    <link rel="stylesheet" type="text/css" href="Inicio.css">
</head>
<body>
<nav class="nav-superior">
        <a href="informacion.php"> <!-- Reemplaza con la URL deseada -->
                <img src="IMAGES/Logo2.jpg" alt="Logo" class="logo"> <!-- Reemplaza logo.png con la ruta de tu imagen -->
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

    <section class="titulo">
        <h1>Información</h1>
    </section>

    <nav class="nav-inicio">
        <ul>
            <li><a href="Informacion.php">Información</a></li>
            <li><a href="prevenciones.php">Prevenciones</a></li>
            <li><a href="cuidados.php">Cuidados</a></li>
        </ul>    
    </nav>

    <div class="contenido">
        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>¿Que es el E.Colli?</h3>
                    <p>Definición</p>
                </div>
            </div>
                <img src="https://www.planet-schule.de/tatort-mensch/deutsch/kurse/kurs1/images/eschcoli_hi.jpg">    
            <div class="cuadro-contenido">
                    <h4>¿Que es E.Colli?</h4>
                    <p>Escherichia coli (E. coli) es una bacteria presente frecuentemente en el intestino distal de los organismos de sangre caliente. La mayoría de las cepas de E. coli son inocuas, pero algunas pueden causar graves intoxicaciones alimentarias.</p>
            </div>
        </div>   

        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Riesgos de la Bacteria</h3>
                    <p>Riesgos</p>
                </div>
            </div>
                <img src="https://staticnew-prod.topdoctors.mx/article/16237/image/large/f9c4b127de1df58900a69691419693c8.jpg">    
            <div class="cuadro-contenido">
                    <h4>Riesgos de la bacteria</h4>
                    <p>Aunque en la mayoría de los casos remite espontáneamente, la enfermedad puede llegar a poner en peligro la vida, por ejemplo cuando da lugar al síndrome hemolítico urémico, especialmente en niños pequeños y ancianos.</p>
            </div>
        </div>  
        
        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Origen</h3>
                    <p>Origen</p>
                </div>
            </div>
                <img src="https://tecnofood.pe/wp-content/uploads/2023/08/1-500x400.gif">    
            <div class="cuadro-contenido">
                    <h4>Origen</h4>
                    <p>El origen principal de los brotes de E. coli productora de toxina Shiga son los productos de carne picada cruda o poco cocinada, la leche cruda y las hortalizas contaminadas por materia fecal.</p>
            </div>
        </div>  

    </div>
</body>
</html>