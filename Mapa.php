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
            <li><a href="registrarSintomas.php">Registrar Síntomas</a></li>
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
// Inicializar el mapa
let map = L.map('map', {
    minZoom: 2 // Establecer el máximo nivel de zoom
}).setView([0, 0], 2); // Coordenadas de inicio y zoom (puedes cambiar a una ubicación predeterminada si prefieres)

// Añadir la capa de mapa base
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Coordenadas fijas (quemadas) que deseas mostrar
const coordenadasFijas = [
    [4.60971, -74.08175],  // Bogotá, Colombia
    [6.25184, -75.56359],  // Medellín, Colombia
    [3.43722, -76.5225],   // Cali, Colombia
    [10.96854, -74.78132], // Cartagena, Colombia
    [4.14325, -73.62535],  // Bucaramanga, Colombia

    // Estados Unidos
    [40.7128, -74.0060],   // Nueva York, EE. UU.
    [34.0522, -118.2437],  // Los Ángeles, EE. UU.
    [41.8781, -87.6298],   // Chicago, EE. UU.
    [29.7604, -95.3698],   // Houston, EE. UU.

    // Canadá
    [45.4215, -75.6992],   // Ottawa, Canadá
    [49.2827, -123.1207],  // Vancouver, Canadá
    [43.6532, -79.3832],   // Toronto, Canadá

    // África
    [6.5244, 3.3792],      // Lagos, Nigeria
    [12.9716, 77.5946],    // Bangalore, India (también se puede ubicar en África dependiendo de tus necesidades)
    [1.2921, 36.8219]      // Nairobi, Kenia
];

// Añadir círculos rojos para las ubicaciones fijas
coordenadasFijas.forEach(coord => {
    L.circle(coord, {
        color: 'red',
        fillColor: 'red',
        fillOpacity: 0.5,
        radius: 300 // Ajusta el radio si lo necesitas
    }).addTo(map)
      .openPopup();
});

// Verificar si hay ubicaciones guardadas en el localStorage y mostrarlas en el mapa
let ubicacionesGuardadas = JSON.parse(localStorage.getItem('ubicacionesUsuario')) || [];

// Añadir círculos rojos para las ubicaciones del localStorage
ubicacionesGuardadas.forEach(coord => {
    L.circle(coord, {
        color: 'red',
        fillColor: 'red',
        fillOpacity: 0.5,
        radius: 300 // Ajusta el radio si lo necesitas
    }).addTo(map)
      .openPopup();
});

// Función para mostrar la ubicación del usuario en el mapa
function mostrarUbicacionEnMapa(coordinates) {
    // Mostrar un círculo rojo para la ubicación del usuario
    L.circle(coordinates, {
        color: 'red',
        fillColor: 'red',
        fillOpacity: 0.5,
        radius: 300 // Ajusta el radio para la ubicación actual
    }).addTo(map)
      .bindPopup("Tu ubicación actual")
      .openPopup();

    // Hacer que el mapa se enfoque en la ubicación del usuario
    map.setView(coordinates, 14);
}

// Añadir límites al mapa (paredes invisibles)
const bounds = [
    [ -90, -180 ], // Coordenada inferior izquierda
    [ 90, 180 ]    // Coordenada superior derecha
];

// Establecer los límites para el mapa
map.setMaxBounds(bounds);


    </script>
</body>
</html>

