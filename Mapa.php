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
    <title>Mapa Interactivo con Leaflet</title>
    <style>
        #map {
            width: 600px;
            height: 600px;
        }

        /* Estilos básicos para el navegador */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url(IMAGES/fondoazul2.jpg) no-repeat;
        }

        /* Estilos para la navegación superior */
        .nav-superior {
            display: flex; /* Utiliza flexbox para la alineación */
            justify-content: center; /* Espaciado entre elementos */
            align-items: center; /* Centra verticalmente */        
            background-color: black; /* Fondo de la barra de navegación */
        }

        /* Estilo para el logo */
        .nav-superior img {
            height: 150px; /* Ajusta la altura del logo */
            width: auto; /* Mantiene la proporción */
            cursor: pointer;
        }

        .nav-principal{
            background-color: #001a52;
        }

        /* Estilos del nav */
        nav {
            color: #fff;
            padding: 10px 0;
            display: flex;
            justify-content: center;
        }
        
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        
        nav ul li {
            margin: 0 15px;
        }
        
        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            padding: 5px 10px;
            transition: background-color 0.3s ease;
        }
        
        nav ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        }

        .logout-btn {
            background-color: #f44336; /* Color de fondo rojo */
            color: white; /* Color del texto */
            padding: 8px 12px; /* Espaciado interno */
            border-radius: 4px; /* Bordes redondeados */
            text-decoration: none; /* Sin subrayado */
        }

        .logout-btn:hover {
            background-color: #d32f2f; /* Color de fondo al pasar el ratón */
        }


        /* Contenedor para centrar el mapa */
        .map-container {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center;     /* Centra verticalmente */
            height: auto;          /* Ocupa toda la altura de la ventana */
            padding: 20px;          /* Espaciado alrededor del mapa */
        }

        /* Estilos para la sección con clase .titulo */
        .titulo {
            text-align: center; /* Centra el contenido dentro de la sección */
            margin: 20px 0; /* Espaciado superior e inferior */
        }

        /* Estilos para el encabezado */
        h1 {
            font-size: 2.5em; /* Tamaño de la fuente */
            color: #333; /* Color del texto */
            background-color: #dbdbdb; /* Color de fondo */
            padding: 20px; /* Espaciado interno */
            margin: 0; /* Elimina márgenes por defecto */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra para profundidad */
            display: inline-block; /* Ajusta el fondo al tamaño del texto */
        }

        /* Línea decorativa debajo del texto */
        h1::after {
            content: "";
            display: block;
            width: 50%; /* Ancho de la línea decorativa */
            height: 4px; /* Altura de la línea */
            background-color: #007BFF; /* Color de la línea */
            margin: 10px auto 0; /* Centra la línea decorativa */
            border-radius: 2px; /* Bordes redondeados para la línea */
        }

        /* Estilo del mapa */
        #map {
            width: 1400px;
            height: 700px;
            border: 2px solid black; /* Borde azul */
            border-radius: 10px;       /* Bordes redondeados */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Sombra para darle profundidad */
        }
        
    </style>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

    <nav class="nav-superior">
    <a href="informacion.php">
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
        <h1>Mapa Interactivo</h1>
    </section>
    
    <div class="map-container">
        <div id="map"></div>
    </div>


    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inicializa el mapa centrado en una ubicación específica sin duplicado horizontal
// Inicializa el mapa centrado en una ubicación específica y con límites estrictos
const map = L.map('map', {
    center: [20, 0], // Centro inicial del mapa
    zoom: 2,
    minZoom: 2,
    maxZoom: 18,
    zoomControl: true,
    maxBounds: [
        [-85, -180],  // Esquina suroeste, ajusta según necesites
        [85, 180]     // Esquina noreste
    ],
    maxBoundsViscosity: 1.0 // Establece la viscosidad en 1.0 para un bloqueo estricto
});

// Capa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);




        // Array para almacenar múltiples coordenadas
        const coordinates = [
            [4.6097, -74.0817],  // Bogotá, Colombia
            [6.2518, -75.5636],  // Medellín, Colombia
            [10.9685, -74.7813], // Barranquilla, Colombia
            [3.4372, -76.5225],  // Cali, Colombia
            [5.0703, -75.5138],  // Manizales, Colombia
            [40.7128, -74.0060], // Nueva York, Estados Unidos
            [34.0522, -118.2437], // Los Ángeles, Estados Unidos
            [51.5074, -0.1278],  // Londres, Reino Unido
            [48.8566, 2.3522],   // París, Francia
            [35.6895, 139.6917], // Tokio, Japón
            [-33.8688, 151.2093], // Sídney, Australia
            [55.7558, 37.6173],  // Moscú, Rusia
            [39.9042, 116.4074], // Pekín, China
            [19.4326, -99.1332], // Ciudad de México, México
            [-23.5505, -46.6333], // São Paulo, Brasil
            [37.7749, -122.4194], // San Francisco, Estados Unidos
            [28.6139, 77.2090],  // Nueva Delhi, India
            [52.5200, 13.4050],  // Berlín, Alemania
            [41.9028, 12.4964],  // Roma, Italia
            [1.3521, 103.8198],  // Singapur
            [31.2304, 121.4737], // Shanghái, China
            [-34.6037, -58.3816], // Buenos Aires, Argentina
            [35.6762, 139.6503], // Osaka, Japón
            [43.6532, -79.3832], // Toronto, Canadá
            [25.276987, 55.296249], // Dubái, Emiratos Árabes Unidos
            [55.6761, 12.5683],  // Copenhague, Dinamarca
            [50.1109, 8.6821],   // Fráncfort, Alemania
            [60.1699, 24.9384],  // Helsinki, Finlandia
            [59.3293, 18.0686],  // Estocolmo, Suecia
            [-22.9068, -43.1729], // Río de Janeiro, Brasil
        ];


        // Itera sobre las coordenadas y agrega un círculo en cada ubicación
        coordinates.forEach(coord => {
            L.circle(coord, {
                color: 'red',
                fillColor: 'red',
                fillOpacity: 0.8,
                radius: 200 // Puedes ajustar el radio para mejor visibilidad
            }).addTo(map);
        });

        // Geolocalización del usuario
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const userLocation = [position.coords.latitude, position.coords.longitude];

                // Centra el mapa en la ubicación del usuario
                map.setView(userLocation, 15);

                // Agrega un círculo rojo en la ubicación del usuario
                L.circle(userLocation, {
                    color: 'red', // Color del borde
                    fillColor: 'red', // Color de relleno
                    fillOpacity: 0.8, // Opacidad
                    radius: 200 // Radio para representar tu posición
                }).addTo(map)
                .bindPopup('Estás aquí')
                .openPopup();
            }, error => {
                console.error("Error obteniendo la ubicación: ", error);
            });
        } else {
            alert("La geolocalización no está soportada por este navegador.");
        }
    </script>
</body>
</html>

