
document.addEventListener('DOMContentLoaded', function() {
    if (mensajeError) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensajeError
        });
    }

    if (mensajeExito) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensajeExito
        });
    }
});
