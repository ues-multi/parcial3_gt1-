self.onmessage = function(event) {
    try {
        const arreglo = []; //arreglo para almacenar los 100,000 numeros
        //Generacion de los numeros
        for (let i = 0; i < 100000; i++) {
            const numero = Math.floor(Math.random() * 100000);
            arreglo.push(numero); //guardado de los numeros
        }
        self.postMessage(arreglo);
    } catch (error) {
        self.postMessage({ error: error.message }); //Envio del arreglo a la vista
    }
};
