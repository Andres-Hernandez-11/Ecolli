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
                <img src="IMAGES/LogoEcolli.jpg" alt="Logo" class="logo"> <!-- Reemplaza logo.png con la ruta de tu imagen -->
        </a>
    </nav>
    <!-- Navegación principal -->
    <nav class="nav-principal">
        <ul>
            <li><a href="informacion.php">Inicio</a></li>
            <li><a href="Mapa.php">Mapa</a></li>
            <li><a href="#sintomas">Síntomas</a></li>
            <li><a href="#contacto">Contacto</a></li>
            <li class="logout-container"><a href="logout.php" class="logout-btn">Cerrar sesión</a></li> 
        </ul>
    </nav>

    <section class="titulo">
        <h1>Prevenciones</h1>
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
                    <h3>Lavado de manos</h3>
                    <p>Igiene</p>
                </div>
            </div>
                <img src="https://staticnew-prod.topdoctors.com.co/article/11585/image/large/a4d162caec325fdb3068e742ee3d9b34.jpg">    
            <div class="cuadro-contenido">
                    <h4>Lavado de manos</h4>
                    <p>Lavarse las manos luego de usar el baño o cambiar pañales y antes de preparar o comer alimentos. Lavese las manos luego de tener contacto con animales o con su medio ambiente (por ejemplo en granjas, zoológico, ferias, o hasta en el patio de tu casa).</p>
            </div>
        </div>   

        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Cocinar Alimentos</h3>
                    <p>Alimentos</p>
                </div>
            </div>
                <img src="https://ensalud.net/wp-content/uploads/2018/03/Temperatura-alimentos.png">    
            <div class="cuadro-contenido">
                    <h4>Cocinar Alimentos</h4>
                    <p>Cocine completamente las carnes. La carne molida de res debe cocinarse hasta alcanzar 160 F (71.1 C). Use un termómetro para alimentos para estar seguro. El color de la carne no es un buen indicador de que la carne esta cocida.</p>
            </div>
        </div>  
        
        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Agua Contaminada</h3>
                    <p>Agua</p>
                </div>
            </div>
                <img src="https://www.islaplagas.com/wp-content/uploads/2022/09/preparar-piscina-para-el-invierno-2.jpg">    
            <div class="cuadro-contenido">
                    <h4>Agua contaminada</h4>
                    <p>Evite tragar agua mientras nada o juega en lagos, arroyos, rios o piscinas públicas o en piscinas portátiles para niños.</p>
            </div>
        </div>  

        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Productos Lacteos Crudos</h3>
                    <p>Lacteos</p>
                </div>
            </div>
                <img src="https://www.topdoctors.es/files/Image/large/63e2a3596eece2d7b36e29a89763be3f.jpeg">    
            <div class="cuadro-contenido">
                    <h4>Productos Lacteos Crudos</h4>
                    <p>Evite tomar leche cruda o sin pasteurizar, productos lácteos producidos con leche no pasteurizada o jugos como cidra, sin pasteurizar.</p>
            </div>
        </div> 
    </div>
</body>
</html>