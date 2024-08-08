var idPreguntaEliminar;

// Abre el modal para agregar un tema.
function agregarTema() {
    modalTema = document.getElementById("modalTema");
    modalTema.style.display = "block";
}

function eliminarTema() {
    modalTema = document.getElementById("eliminaTema");
    modalTema.style.display = "block";
}

// Cierra el modal del tema.
function cerrarTema() {
    modalTema = document.getElementById("modalTema");
    modalTema.style.display = "none";
}

function cerrar_Tema() {
    modalTema = document.getElementById("eliminaTema");
    modalTema.style.display = "none";
}

// Cierra el modal de la pregunta.
function cerrarEliminar() {
    modalPregunta = document.getElementById("modalPregunta");
    modalPregunta.style.display = "none";
}

// Redirige a la página de edición de la pregunta con el ID proporcionado.
function editarPregunta(idPregunta) {
    window.location.href = "editarpregunta.php?idPregunta=" + idPregunta;
}

// Redirige a la página para eliminar la pregunta con el ID almacenado.
function eliminarPregunta() {
    window.location.href = "eliminarpregunta.php?idPregunta=" + idPreguntaEliminar;
}

// Abre el modal para confirmar la eliminación de una pregunta.
function abrirModalEliminar(idPregunta) {
    idPreguntaEliminar = idPregunta;
    modalPregunta = document.getElementById("modalPregunta");
    modalPregunta.style.display = "block";
}

// Marca la página activa en el menú de iconos.
function paginaActiva(id) {
    var paginas = document.querySelectorAll(".icono");
    for (i = 0; i < paginas.length; i++) {
        paginas[i].className = "icono";
    }
    paginas[id].className = "icono selected";
}

document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const mensajeExito = urlParams.get('mensaje_exito');
    const mensajeError = urlParams.get('mensaje_error');

    if (mensajeExito) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensajeExito,
            confirmButtonText: 'OK'
        });
    }

    if (mensajeError) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensajeError,
            confirmButtonText: 'OK'
        });
    }

    var altaButton = document.querySelector('button[name="Alta"]');
    if (altaButton) {
        altaButton.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres crear esta nueva partida?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, crearla'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('crear-partida-form').submit();
                }
            });
        });
    }

    document.querySelectorAll('.eliminar-partida-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarla'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
});