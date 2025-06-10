@extends('backend.app')

@section('title', 'Panel APIs')


@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5 fw-bold">APIs en el Navegador</h1>

    {{-- Sección: API de Video --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">📸 API de Video (Cámara)</h3>
        </div>
        <div class="card-body text-center">
            <video id="video" width="640" height="480" class="rounded border mb-3" autoplay></video><br>
            <button id="snap" class="btn btn-primary">Tomar Foto</button><br>
            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
            <img id="photo" alt="Captura" class="mt-3 border rounded d-block mx-auto" />
            <a id="download" class="btn btn-success mt-2" style="display:none;" download="captura.png">Descargar Imagen</a>
        </div>
    </div>

    {{-- Sección: API de Geolocalización --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">📍 API de Geolocalización</h3>
        </div>
        <div class="card-body text-center">
            <p class="fw-semibold">Ubicación actual:</p>
            <p><strong>Latitud:</strong> <span id="latitud">-</span></p>
            <p><strong>Longitud:</strong> <span id="longitud">-</span></p>
            <div id="map" class="border rounded" style="height: 400px;"></div>
        </div>
    </div>

    {{-- Sección: API de Canvas --}}
    <div class="card shadow-sm mb-5">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">🎨 API de Canvas (Dibujo)</h3>
        </div>
        <div class="card-body text-center">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <label for="colorPicker" class="me-2 fw-semibold">Color del trazo:</label>
                <input type="color" id="colorPicker" value="#000000" class="form-control form-control-color">
            </div>
            <canvas id="drawCanvas" width="640" height="480" class="border rounded shadow" style="cursor: crosshair;"></canvas><br>
            <button id="saveCanvas" class="btn btn-success mt-3">Guardar Dibujo</button>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<!-- LeafletJS para el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// API de Video
document.addEventListener("DOMContentLoaded", function () {
const video = document.getElementById("video");
const canvas = document.getElementById("canvas");
const photo = document.getElementById("photo");
const snap = document.getElementById("snap");
const download = document.getElementById("download");

// Solicitar acceso a la cámara
navigator.mediaDevices.getUserMedia({ video: true })
    .then(function (stream) {
        video.srcObject = stream;
    })
    .catch(function (err) {
        console.error("Error al acceder a la cámara: ", err);
    });

// Tomar foto
snap.addEventListener("click", function () {
    const context = canvas.getContext("2d");
    context.drawImage(video, 0, 0, canvas.width, canvas.height);
    const dataURL = canvas.toDataURL("image/png");

    // Mostrar imagen capturada
    photo.setAttribute("src", dataURL);
    photo.style.display = "block";

    // Preparar descarga
    download.href = dataURL;
    download.style.display = "inline-block";
});


    // API de Geolocalización
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.getElementById("latitud").textContent = lat;
            document.getElementById("longitud").textContent = lng;

            // Inicializar mapa
            const map = L.map('map').setView([lat, lng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup("Tu ubicación actual")
                .openPopup();
        }, function (error) {
            alert("No se pudo obtener la ubicación.");
            console.error(error);
        });
    } else {
        alert("Geolocalización no es soportada por tu navegador.");
    }
});

const canvasDraw = document.getElementById("drawCanvas");
const ctx = canvasDraw.getContext("2d");
const colorPicker = document.getElementById("colorPicker");

let drawing = false;
let currentColor = colorPicker.value;

colorPicker.addEventListener("input", () => {
    currentColor = colorPicker.value;
});

canvasDraw.addEventListener("mousedown", () => drawing = true);
canvasDraw.addEventListener("mouseup", () => drawing = false);
canvasDraw.addEventListener("mouseout", () => drawing = false);

canvasDraw.addEventListener("mousemove", draw);

function draw(event) {
    if (!drawing) return;
    const rect = canvasDraw.getBoundingClientRect();
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;

    ctx.fillStyle = currentColor;
    ctx.beginPath();
    ctx.arc(x, y, 2, 0, Math.PI * 2);
    ctx.fill();
}

document.getElementById("saveCanvas").addEventListener("click", () => {
    const image = canvasDraw.toDataURL("image/jpeg");
    const a = document.createElement("a");
    a.href = image;
    a.download = "dibujo.jpg";
    a.click();
});


</script>
@endpush
