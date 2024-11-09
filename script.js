// Dentro del script de la encuesta
function calcularRiesgo() {
    const sintomas = document.querySelectorAll('input[name="sintoma"]:checked');
    const cantidadSeleccionada = sintomas.length;
    const duracionSintomas = document.getElementById("duracionSintomas").value;
    const severidad = document.querySelector('input[name="severidad"]:checked');
    const temperatura = parseFloat(document.getElementById("temperatura").value);
    const resultado = document.getElementById("resultado");
    const ubicacionButton = document.getElementById("ubicacionButton");

    // Validaciones de entrada
    if (cantidadSeleccionada === 0) {
        resultado.textContent = "Por favor seleccione al menos un síntoma.";
        ubicacionButton.style.display = "none";
        return;
    }
    if (!duracionSintomas || duracionSintomas <= 0) {
        resultado.textContent = "Por favor ingrese una duración válida para los síntomas.";
        ubicacionButton.style.display = "none";
        return;
    }
    if (!severidad) {
        resultado.textContent = "Por favor seleccione la severidad de los síntomas.";
        ubicacionButton.style.display = "none";
        return;
    }
    if (isNaN(temperatura) || temperatura < 35 || temperatura > 42) {
        resultado.textContent = "Por favor ingrese una temperatura corporal válida entre 35°C y 42°C.";
        ubicacionButton.style.display = "none";
        return;
    }

    // Cálculo del porcentaje de riesgo
    let porcentajeRiesgo = 0;
    porcentajeRiesgo += (cantidadSeleccionada / 5) * 40;

    sintomas.forEach(sintoma => {
        if (sintoma.value === "diarrea_sangre") {
            porcentajeRiesgo += 20;
        }
    });

    if (temperatura >= 38) {
        porcentajeRiesgo += 15;
    }
    if (duracionSintomas > 3) {
        porcentajeRiesgo += 10;
    }

    if (severidad.value === "moderado") {
        porcentajeRiesgo += 10;
    } else if (severidad.value === "severo") {
        porcentajeRiesgo += 20;
    }

    porcentajeRiesgo = Math.min(porcentajeRiesgo, 100);

    // Mostrar mensaje basado en el nivel de riesgo
    if (porcentajeRiesgo <= 40) {
        resultado.innerHTML = `Riesgo de contagio estimado: ${porcentajeRiesgo.toFixed(2)}%<br>Tus síntomas no representan una alta probabilidad de contagio por E. coli.`;
        ubicacionButton.style.display = "none";
    } else if (porcentajeRiesgo <= 60) {
        resultado.innerHTML = `Riesgo de contagio estimado: ${porcentajeRiesgo.toFixed(2)}%<br>Tus síntomas representan una mediana posibilidad de contagio. Te recomendamos acudir a un centro de salud para una revisión adecuada.`;
        ubicacionButton.style.display = "none";
    } else {
        resultado.innerHTML = `Riesgo de contagio estimado: ${porcentajeRiesgo.toFixed(2)}%<br>Tus síntomas representan una alta posibilidad de contagio. Te sugerimos acudir a un centro de salud especializado y permitirnos compartir tu ubicación para ayudar en el control de la posible propagación.`;
        ubicacionButton.style.display = "block"; // Mostrar el botón para compartir ubicación
    }

    // Si el riesgo es mayor que 60%, agregar la ubicación al localStorage
    if (porcentajeRiesgo > 60) {
        ubicacionButton.addEventListener("click", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(position => {
                    const userLocation = [position.coords.latitude, position.coords.longitude];

                    // Obtener el array de ubicaciones previamente guardadas en localStorage (si existe)
                    let ubicacionesGuardadas = JSON.parse(localStorage.getItem('ubicacionesUsuario')) || [];

                    // Agregar la nueva ubicación al array
                    ubicacionesGuardadas.push(userLocation);

                    // Guardar el array actualizado de ubicaciones en localStorage
                    localStorage.setItem('ubicacionesUsuario', JSON.stringify(ubicacionesGuardadas));

                    // Llamar a la función para mostrar el punto rojo en el mapa
                    mostrarUbicacionEnMapa(userLocation);
                    
                }, error => {
                    console.error("Error obteniendo la ubicación: ", error);
                });
            } else {
                alert("La geolocalización no está soportada por este navegador.");
            }

            
        });
    }
}
