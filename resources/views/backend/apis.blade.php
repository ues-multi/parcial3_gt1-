@extends('backend.menus.superior')

@section('titulo', 'API de Canvas')

@section('content')

<div class="container mt-4">
    <h2>API de Canvas</h2>

    <div class="mb-3">
        <label for="colorPicker" class="form-label">Color del lápiz:</label>
        <input type="color" id="colorPicker" value="#000000" class="form-control form-control-color w-auto">
    </div>

    <canvas id="drawingCanvas" width="800" height="500" style="border:1px solid #000; cursor: crosshair;"></canvas>

    <div class="mt-3">
        <button id="saveBtn" class="btn btn-success">Guardar como JPG</button>
        <button id="clearBtn" class="btn btn-secondary ms-2">Limpiar</button>
    </div>
</div>

@endsection

@section('scripts')
<script>
    const canvas = document.getElementById('drawingCanvas');
    const ctx = canvas.getContext('2d');
    const saveBtn = document.getElementById('saveBtn');
    const clearBtn = document.getElementById('clearBtn');
    const colorPicker = document.getElementById('colorPicker');

    // Pintar fondo blanco al inicio
    ctx.fillStyle = 'white';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    let isDrawing = false;

    canvas.addEventListener('mousedown', (e) => {
        isDrawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (isDrawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.strokeStyle = colorPicker.value;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.stroke();
        }
    });

    canvas.addEventListener('mouseup', () => {
        isDrawing = false;
    });

    canvas.addEventListener('mouseleave', () => {
        isDrawing = false;
    });

    saveBtn.addEventListener('click', () => {
        const link = document.createElement('a');
        link.download = 'dibujo.jpg';
        link.href = canvas.toDataURL('image/jpeg', 0.9);
        link.click();
    });

    clearBtn.addEventListener('click', () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'white';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    });
</script>
@endsection
