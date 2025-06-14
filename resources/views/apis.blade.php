@extends('backend.app')

@section('title', 'API de VIDEO')

@section('content')
<div class="container py-4">
    <h1 class="text-center mb-5 fw-bold">📸 API de Video (Cámara)</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h3 class="mb-0">Captura de Imagen desde la Cámara</h3>
        </div>
        <div class="card-body text-center">
            <video id="video" width="640" height="480" class="rounded border mb-3" autoplay></video><br>
            <button id="snap" class="btn btn-primary">Tomar Foto</button><br>
            <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
            <img id="photo" alt="Captura" class="mt-3 border rounded d-block mx-auto" />
            <a id="download" class="btn btn-success mt-2" style="display:none;" download="captura.png">Descargar Imagen</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const video = document.getElementById("video");
    const canvas = document.getElementById("canvas");
    const photo = document.getElementById("photo");
    const snap = document.getElementById("snap");
    const download = document.getElementById("download");

    try {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                video.srcObject = stream;
            })
            .catch(function (err) {
                console.error("Error al acceder a la cámara: ", err);
                alert("No se pudo acceder a la cámara.");
            });
    } catch (error) {
        console.error("Excepción inesperada:", error);
        alert("Error general al solicitar la cámara.");
    }

    snap.addEventListener("click", function () {
        try {
            const context = canvas.getContext("2d");
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const dataURL = canvas.toDataURL("image/png");

            // Mostrar imagen capturada
            photo.setAttribute("src", dataURL);
            photo.style.display = "block";

            // Preparar descarga
            download.href = dataURL;
            download.style.display = "inline-block";
        } catch (error) {
            console.error("Error al capturar la imagen:", error);
            alert("Ocurrió un error al capturar la imagen.");
        }
    });
});
</script>
@endpush
