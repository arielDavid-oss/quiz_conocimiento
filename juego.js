let numJugadores = 2; // Inicialmente hay 2 jugadores
//Agregar nuevo campo para los jugadores
function agregarJugador() {
    if (numJugadores < 5) {
        const listaJugadores = document.getElementById('player-list');
        const nuevoJugador = document.createElement('div');
        nuevoJugador.classList.add('input-container');
        nuevoJugador.innerHTML = `<i class="bi bi-person-circle"></i>
            <input class="text-center" type="text" name="nombre[]" placeholder="Nombre completo" required>`;
        listaJugadores.appendChild(nuevoJugador);
        numJugadores++;
    } else {
        alert('No puedes agregar más de 5 jugadores');
}
}
//Eliminar campo por si se equivocan
function removerJugador(button) {
    if (numJugadores > 2) {
        const listaJugadores = document.getElementById('player-list');
        listaJugadores.removeChild(listaJugadores.lastElementChild);
        numJugadores--;
    } else {
        alert('Debes tener al menos 2 jugadores.');
    }
}

//Animacion para seleccionar solo una opcion y cambie el color
function seleccionar(labelSeleccionado) {
    var labels = document.getElementsByTagName("label");
    labels[0].className = "";
    labels[1].className = "";
    labels[2].className = "";
    labels[3].className = "";
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

// Función para cambiar de pregunta si se acaba el tiempo asignado
function iniciarContador(tiempoRestante) {
    //Obtener elementos = id del formulario 
    var contadorElement = document.getElementById('contador');
    var formPregunta = document.getElementById('form-pregunta');

    var intervalo = setInterval(function() {
        tiempoRestante--;
        contadorElement.textContent = tiempoRestante;
        if (tiempoRestante <= 0) {
            clearInterval(intervalo);
            // Enviar el formulario automáticamente cuando se termine el tiempo
            formPregunta.submit(); 
        }
    }, 1000);
}

// Iniciar el contador al cargar la página con el tiempo de pregunta desde PHP
window.onload = function() {
    iniciarContador(tiempoPregunta);
};