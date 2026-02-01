function toggleTexto(button) {
        const contenedorTexto = button.previousElementSibling;
        button.classList.toggle('expandido');
        contenedorTexto.classList.toggle('expandido');
        
        if (button.classList.contains('expandido')) {
            button.textContent = 'Mostrar menos';
        } else {
            button.textContent = 'Mostrar más';
        }
    }

// Detecta automáticamente qué posts necesitan el botón "Mostrar más"
document.addEventListener('DOMContentLoaded', function() {
    const contenedoresTexto = document.querySelectorAll('.contenido__texto');
        
    contenedoresTexto.forEach(contenedor => {
        const parrafo = contenedor.querySelector('p');
            
        // Calcula la altura del párrafo
        const alturaLinea = parseInt(getComputedStyle(parrafo).lineHeight);
        const alturaMaxima = alturaLinea * 5; // 5 líneas
            
        if (parrafo.scrollHeight > alturaMaxima) {
            contenedor.classList.add('necesita__expandir');
        }
    });
});
