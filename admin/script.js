var idPreguntaEliminar;

// Abre el modal para agregar un tema.
function agregarTema() {
    modalTema = document.getElementById("modalTema");
    modalTema.style.display = "block";
}

// Cierra el modal del tema.
function cerrarTema() {
    modalTema = document.getElementById("modalTema");
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
