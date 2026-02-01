document.addEventListener('DOMContentLoaded', function() {
    const btnEditar = document.getElementById('btn__editar');

    btnEditar.addEventListener('click', function() {
        window.location.href = 'formEditarPerfil.php';
    });
});