document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscador'); 
    const listaUsuarios = document.getElementById('lista-usuarios'); 
    
    // El array from convierte cosas en listas de arrays
    const usuariosOriginales = Array.from(listaUsuarios.getElementsByClassName('usuario-item'));
    
    function configurarBotones() 
    {
        const botones = document.querySelectorAll(".explorar__usuarios__boton");
        
        botones.forEach(function(boton) {
            boton.onclick = function() {
                // Busco el usuario del boton
                const divUsuario = this.closest('.usuario-item');
                
                // Busco la columna del nombre de es eboton
                const elementoNombre = divUsuario.querySelector('.nombre-usuario');
                
                // Si lo encuentro, redirijo
                if (elementoNombre) 
                {
                    const username = elementoNombre.textContent;
                    window.location.href = 'ViewVerUsuario.php?username=' + encodeURIComponent(username);
                }
            };
        });
    }
    
    // Lamo a la funcion para que los botones funcionen
    configurarBotones();
    
    // Esta es la siguiente funcion que se activa cuando escribo en el input
    buscador.addEventListener('input', function() {
        const textoBusqueda = this.value.toLowerCase().trim(); 
        
        listaUsuarios.innerHTML = '';
        
        // Si no escribo nada, muestro todos los usuarios
        if (textoBusqueda === '') {
            usuariosOriginales.forEach(usuario => {
                listaUsuarios.appendChild(usuario);
            });
            
            configurarBotones();
            return;
        }
        
        // Filtra los usuarios que contengan el texto buscado
        const usuariosFiltrados = usuariosOriginales.filter(usuario => {
            const elementosP = usuario.getElementsByClassName('nombre-usuario');
            if (elementosP.length > 0) 
            {
                const nombreUsuario = elementosP[0].textContent.toLowerCase();
                return nombreUsuario.includes(textoBusqueda); 
            }
            return false;
        });
        
        // Si encontró usuarios, los muestra
        if (usuariosFiltrados.length > 0) {
            usuariosFiltrados.forEach(usuario => {
                listaUsuarios.appendChild(usuario);
            });
            
            configurarBotones();
        } 
        else {
            // Si no encontró, muestra un mensaje
            const mensaje = document.createElement('p');
            mensaje.className = 'no-resultados';
            mensaje.textContent = 'No se encontraron usuarios con ese nombre';
            listaUsuarios.appendChild(mensaje);
        }
    });
    
    // Pone el cursor automáticamente en el buscador
    buscador.focus();
});