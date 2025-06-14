@extends('backend.menus.superior')

<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <title>Geolocalización</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">

   <!-- Bootstrap 5 -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

   <!-- Leaflet CSS -->
   <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

   <style>
    body {
       background: linear-gradient(135deg,rgb(255, 254, 242) 0%,rgb(194, 232, 251) 100%);
       font-family: 'Poppins', sans-serif;
       color: #333;
       min-height: 100vh;
       display: flex;
       justify-content: center;
       align-items: center;
       padding: 20px;
    }
    .container {
       background: white;
       padding: 30px 40px;
       border-radius: 15px;
       box-shadow: 0 8px 20px rgba(37, 109, 147, 0.64);
       max-width: 500px;
       width: 100%;
       text-align: center;
   }
   h2 {
       font-weight: 700;
       margin-bottom: 25px;
       color:rgb(240, 240, 204);
       text-shadow: 1px 1px 4px rgb(0, 81, 135);
   }
   #map {
       height: 350px;
       border-radius: 12px;
       margin-top: 20px;
       box-shadow: 0 4px 12px rgba(239, 238, 212, 0.57);
   }

   button.btn-primary {
       background:rgb(9, 98, 136);
       border: none;
       padding: 12px 25px;
       font-size: 1.1rem;
       font-weight: 600;
       border-radius: 30px;
       transition: background 0.3s ease;
       cursor: pointer;
   }
   button.btn-primary:hover {
       background:rgb(58, 122, 160);
       box-shadow: 0 0 8pxrgb(58, 124, 160);
   }

   p {
       font-size: 1.15rem;
       margin: 8px 0;
       font-weight: 600;
       color: #444;
   }

   /* Estilo para las coordenadas */
   #latitud, #longitud {
       color:rgb(30, 97, 114);
       font-family: 'Courier New', Courier, monospace;
       font-size: 1.2rem;
       background: #e3f2fd;
       padding: 6px 12px;
       border-radius: 8px;
       display: inline-block;
       min-width: 150px;
   }
   /* Animación de carga*/
   .loading-spinner {
   border: 4px solid rgb(243, 238, 220);
   border-top: 4px solid rgb(30, 100, 114);
   border-radius: 50%;
   width: 24px;
   height: 24px;
   animation: spin 1s linear infinite;
   display: inline-block;
   vertical-align: middle;
   margin-left: 10px;
}

button.btn-primary {
   width: 100%;
   font-size: 1rem;
}

   </style>
</head>
<body>

<div class="container mt-4">
   <h2 class="mb-4">Mi Ubicación Actual</h2>

   <!-- Coordenadas mostradas aquí -->
   <p><strong>Latitud:</strong> <span id="latitud">Cargando... <span class="loading-spinner"></span></span></p>
    <p><strong>Longitud:</strong> <span id="longitud">Cargando... <span class="loading-spinner"></span></span></p>

   <button class="btn btn-primary mb-3" onclick="getLocation()">Obtener mi ubicación</button>

   <div id="map" class="border"></div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
   let map;

   // Llamar automáticamente a getLocation al cargar la página
   window.onload = function() {
       getLocation(); 
   };

   function getLocation() {
       console.log("Obteniendo ubicación...");
       if (navigator.geolocation) {
           navigator.geolocation.getCurrentPosition(showPosition, showError);
       } else {
           alert("Geolocalización no soportada.");
       }
   }

   function showPosition(position) {
       const lat = position.coords.latitude;
       const lon = position.coords.longitude;
       console.log("Ubicación: ", lat, lon);

       // Mostrar las coordenadas en el HTML
       document.getElementById('latitud').innerHTML = lat.toFixed(6);
        document.getElementById('longitud').innerHTML = lon.toFixed(6);


       if (!map) {
           map = L.map('map').setView([lat, lon], 13);
           L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
               attribution: '© OpenStreetMap contributors'
           }).addTo(map);
       } else {
           map.setView([lat, lon], 13);
       }

       L.marker([lat, lon]).addTo(map)
           .bindPopup("¡Estás aquí!")
           .openPopup();
   }

   function showError(error) {
       console.error("Error al obtener ubicación:", error);
       switch (error.code) {
           case error.PERMISSION_DENIED:
               alert("Permiso denegado para obtener ubicación.");
               break;
           case error.POSITION_UNAVAILABLE:
               alert("Ubicación no disponible.");
               break;
           case error.TIMEOUT:
               alert("Tiempo de espera excedido.");
               break;
           case error.UNKNOWN_ERROR:
               alert("Error desconocido.");
               break;
       }
   }
</script>

</body>
</html>

