<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Generación de Números</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark p-4">

    <div class="container">
        <h1 class="mb-4 text-center">Generación de Números Aleatorios</h1>

        <div class="card">
            <div class="card-header bg-success text-white">
                Primeros 50 Números Ordenados
            </div>
            <div class="card-body">
                <pre id="lista_orden"></pre>
            </div>
        </div>

        <div id="loading" class="text-center my-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                Lista Completa de Números (100,000)
            </div>
            <div class="card-body" style="max-height: 300px; overflow-y: scroll;">
                <pre id="lista" class="text-wrap"></pre>
            </div>
        </div>
    </div>

    <script>
        let worker = new Worker('{{ asset('js/webworker/worker.js') }}');
        let arreglo = [];
        const loading = document.getElementById('loading');
        const lista = document.getElementById('lista');
        const lista2 = document.getElementById('lista_orden');

        worker.onmessage = function(event) {
           try {
            arreglo = event.data;

            if (!Array.isArray(arreglo)) {
                throw new Error("Los datos recibidos no son un arreglo.");
            }

            loading.style.display = 'none';
            lista.textContent = JSON.stringify(arreglo, null, 2);

            let ordenados = arreglo.slice().sort((a, b) => a - b).slice(0, 50);
            lista2.textContent = ordenados.join(', ');

            } catch (error) {
                loading.innerHTML = `<div class="alert alert-danger">Error al procesar datos: ${error.message}</div>`;
            }
        };

        worker.onerror = function(e) {
            loading.innerHTML = `<div class="alert alert-danger">Error: ${e.message}</div>`;
        };

        worker.postMessage('generar');
    </script>
</body>
</html>
