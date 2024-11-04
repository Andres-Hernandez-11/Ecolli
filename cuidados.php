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
        <h1>Cuidados</h1>
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
                    <h3>No consumir medicamentos</h3>
                    <p>Medicamentos</p>
                </div>
            </div>
                <img src="https://www.farmaciavillanueva.es/wp-content/uploads/2020/10/freestocks-nss2eRzQwgw-unsplash-center-top-500x400.jpg">    
            <div class="cuadro-contenido">
                    <h4>No consumir medicamentos</h4>
                    <p>No utilice medicamentos antidiarreicos de venta libre si tiene diarrea. Estos productos incluyen Imodium o Maalox Anti-Diarrheal.</p>
            </div>
        </div>   

        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Alimentación Suave para Recuperarse</h3>
                    <p>Alimentos</p>
                </div>
            </div>
                <img src="https://losantojos.co/sitio/wp-content/uploads/2024/02/5954bcb006b10dbfd0bc160f6370faf3-15-1-500x400.jpeg">    
            <div class="cuadro-contenido">
                    <h4>Alimentación</h4>
                    <p>Comience comiendo pequeñas cantidades de alimentos suaves y bajos en grasa, dependiendo de cómo se siente. Pruebe alimentos como arroz, galletas saladas secas, bananas (plátanos) y puré de manzana.</p>
            </div>
        </div>  
        
        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Prevención de la Deshidratación</h3>
                    <p>Hidatación</p>
                </div>
            </div>
                <img src="https://www.topdoctors.es/files/Image/large/45782bcfb29d539be87a6c07ddd317c5.jpg">    
            <div class="cuadro-contenido">
                    <h4>Prevención de la Deshidratación</h4>
                    <p>Para evitar la deshidratación, bebe abundantes líquidos claros, como agua, hasta que tu orina sea de color claro. Si tienes enfermedades renales, cardíacas o hepáticas, consulta a tu médico antes de aumentar la ingesta de líquidos.</p>
            </div>
        </div>  

        <div class="cuadro">
            <div class="cuadro-superior">
                <div class="texto-cuadro">
                    <h3>Recuperación Natural de la E.colli</h3>
                    <p>Recuperación</p>
                </div>
            </div>
                <img src="https://www.topdoctors.es/files/Image/large/4bb76410c01b77c6fd88c30c6f0049cf.jpg">    
            <div class="cuadro-contenido">
                    <h4>Recuperación natural de la E.Colli</h4>
                    <p>La E. coli suele desaparecer por sí sola. Por lo general, usted no necesita antibióticos.</p>
            </div>
        </div> 
    </div>

</body>
</html>