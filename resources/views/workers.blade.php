<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Web Worker Números</title>
</head>
<body>
    <h2>Generacion de numeros</h2>
    <ul id="lista"></ul>
    <h2>Primeros 50 numeros</h2>
    <ul id="lista_orden"></ul>

   <script>
    let worker = new Worker('{{ asset('js/webworker/worker.js') }}');
    let arreglo = [];

    worker.onmessage = function(event) {
        const data = event.data;
        const lista = document.getElementById('lista');
        const lista2 = document.getElementById('lista_orden');

        if (data.error) {
            lista.textContent = "Error en worker: " + data.error;
            lista2.textContent = "";
            return;
        }

        arreglo = data;
        lista.textContent = JSON.stringify(arreglo, null, 2);
        let ordenados = arreglo.slice().sort((a, b) => a - b).slice(0, 50);
        lista2.textContent = JSON.stringify(ordenados, null, 2);
    };

    worker.onerror = function(e) {
        console.error("Error interno en el worker:", e.message);
    };

    worker.postMessage('generar');
</script>

</body>
</html>
