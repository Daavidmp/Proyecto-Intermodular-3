function configurarBtnEditar() {
    const btnEditar = document.getElementById('btn__editar');
    if (btnEditar) {
        btnEditar.onclick = function() {
            loadSection('formEditarPerfil.php');
        };
    }
}