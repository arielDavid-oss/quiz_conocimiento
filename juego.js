function seleccionar(labelSeleccionado) {
    var labels = document.getElementsByTagName("label");
    labels[0].className = "";
    labels[1].className = "";
    labels[2].className = "";
    labelSeleccionado.className = "opcionSeleccionada";
}

$(function() {
    $('.chart').easyPieChart({
        size: 160,
        barColor: "#36e617",
        scaleLength: 0,
        lineWidth: 15,
        trackColor: "#525151",
        lineCap: "circle",
        animate: 2000,
    });

});

// Habilitar botón después de seleccionar una respuesta
document.addEventListener("DOMContentLoaded", function() {
    // Obtener todos los elementos del radioButton
    const opciones = document.querySelectorAll('input[name="respuesta"]');
    const btnsiguinete = document.querySelector('#btn_siguiente');
    // Agregar un eventListener a cada radioButton
    opciones.forEach(element => {
        element.addEventListener('change', function() {
            // Habilitar botón después de seleccionar una respuesta
            if (this.checked) {
                btnsiguinete.disabled = false;
            }
        });
    });
});

function iniciarContador(tiempoRestante) {
    var contadorElement = document.getElementById('contador');
    var formPregunta = document.getElementById('form-pregunta');


    var intervalo = setInterval(function() {
        tiempoRestante--;
        contadorElement.textContent = tiempoRestante;

        if (tiempoRestante <= 0) {
            clearInterval(intervalo);
            formPregunta.submit(); // Enviar el formulario automáticamente
        }
    }, 1000);
}

// Iniciar el contador al cargar la página con el tiempo de pregunta desde PHP
window.onload = function() {
    iniciarContador(tiempoPregunta);
};