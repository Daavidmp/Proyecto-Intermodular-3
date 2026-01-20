document.addEventListener('DOMContentLoaded', function() {
    const btnEditar = document.getElementById('btn__editar');
    const btnPerfil = document.getElementById('btn__perfil');
    const btnExplorar = document.getElementById('btn__explorar');

    btnExplorar.addEventListener('click', function() {
        window.location.href = '../views/formExplorar.php';
    });

    btnPerfil.addEventListener('click', function() {
        window.location.href = '../views/formMenu.php';
    });

    btnEditar.addEventListener('click', function() {
        window.location.href = 'formEditarPerfil.php';
    });
});