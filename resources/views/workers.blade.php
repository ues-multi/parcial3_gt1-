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
        let arreglo = [];//arreglo
        //gernar numeros
        worker.onmessage = function(event) {
            //mostrar arreglo
             arreglo = event.data; // El arreglo recibido
             const lista = document.getElementById('lista');            
             //mostrar arreglo con los 100,000 en vista
            lista.textContent = JSON.stringify(arreglo, null,2)
            //otra lista para mostrar los primeros 50
            const lista2 = document.getElementById('lista_orden');
            //oredena los los numeros de menor a mayor y solo los primero 50
            let ordenados = arreglo.sort((a, b) => (a-b)).slice(0,50);
            //Muestra los primeros 50 numeros ya ordenados en la vista
            lista2.textContent = JSON.stringify(ordenados, null,2)
             
        };
        
        // Enviar mensaje para activar el worker
        worker.postMessage('generar');
    </script>
</body>
</html>
