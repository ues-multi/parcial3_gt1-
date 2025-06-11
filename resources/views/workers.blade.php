<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Web Worker Números</title>
</head>
<body>
    <h2>Generacion de numeros</h2>
    <ul id="lista"></ul>
    

    <script>
        let worker = new Worker('{{ asset('js/webworker/worker.js') }}');//llama al worker y genera uno nuevo

        worker.onmessage = function(event) {
            //mostrar arreglo
            const arreglo = event.data; // El arreglo recibido
             const lista = document.getElementById('lista');
            
             //mostrar arreglo en vista
            lista.textContent = JSON.stringify(arreglo, null,2)
            
        };
        // Enviar mensaje para activar el worker
    worker.postMessage('generar');
    </script>
</body>
</html>
