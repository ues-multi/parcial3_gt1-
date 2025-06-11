self.onmessage = function(event) {
    const arreglo = [];//arreglo para almacenar los 100,000 numeros
    //Generacion de los numeros
    for (let i = 0; i < 100000; i++) {
      const numero =Math.floor(Math.random()*1000);
      arreglo.push(numero);//guardado de los numeros
    }
    self.postMessage(arreglo); //Envio del arreglo a la vista
};
