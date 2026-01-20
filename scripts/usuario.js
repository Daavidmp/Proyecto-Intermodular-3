document.addEventListener('DOMContentLoaded', function() {
    const buscador = document.getElementById('buscador');
    const listaUsuarios = document.getElementById('lista-usuarios');
    
    const usuariosOriginales = Array.from(listaUsuarios.getElementsByClassName('usuario-item'));
    
    function hacerBotonesFuncionales() {
        const botones = document.querySelectorAll(".explorar__usuarios__boton");
        
        // Para cada boton creo una función onclick
        botones.forEach(function(boton) {
            boton.onclick = function() {
                const divUsuario = this.closest('.usuario-item');
                
                const elementoNombre = divUsuario.querySelector('.nombre-usuario');
                
                if (elementoNombre) {
                    const username = elementoNombre.textContent;
                    console.log("Ir a perfil de: " + username);
                    
                    window.location.href = 'ViewVerUsuario.php?username=' + encodeURIComponent(username);
                }
            };
        });
        
        console.log("Botones configurados: " + botones.length);
    }
    
    hacerBotonesFuncionales();
    
    buscador.addEventListener('input', function() {
        const textoBusqueda = this.value.toLowerCase().trim();
        console.log("Buscando: " + textoBusqueda);
        
        listaUsuarios.innerHTML = '';
        
        if (textoBusqueda === '') 
        {
            usuariosOriginales.forEach(usuario => {
                listaUsuarios.appendChild(usuario);
                usuario.style.display = 'flex';
            });
            
            hacerBotonesFuncionales();
            return;
        }
        
        // Aqui filtro los usuarios que he buscado
        const usuariosFiltrados = usuariosOriginales.filter(usuario => {
            const elementosP = usuario.getElementsByClassName('nombre-usuario');
            if (elementosP.length > 0) {
                const nombreUsuario = elementosP[0].textContent.toLowerCase();
                return nombreUsuario.includes(textoBusqueda);
            }
            return false;
        });
        
        console.log("Usuarios encontrados: " + usuariosFiltrados.length);
        
        if (usuariosFiltrados.length > 0) 
        {
            usuariosFiltrados.forEach(usuario => {
                listaUsuarios.appendChild(usuario);
                usuario.style.display = 'flex';
            });
            
            hacerBotonesFuncionales();
        } 
        else 
        {
            // Mostrar mensaje si no hay resultados
            const mensaje = document.createElement('p');
            mensaje.className = 'no-resultados';
            mensaje.textContent = 'No se encontraron usuarios con ese nombre';
            listaUsuarios.appendChild(mensaje);
        }
    });
    
    // Enfocar el buscador al cargar
    buscador.focus();
});