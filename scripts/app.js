// ── Inicializa todo lo que depende del contenido cargado ──────────────────
function initDynamicContent() {
    // FIX #6: eliminada setupNavigation() que era una función vacía
    initMostrarMas();
    initBuscador();
    initSeguir();
    initLikes();
}

// ── Navegación SPA ────────────────────────────────────────────────────────
document.addEventListener('click', function (e) {
    const target = e.target.closest('[data-url]');
    if (!target) return;
    e.preventDefault();
    loadSection(target.getAttribute('data-url'));
});

// ── Ejecutar scripts inyectados via innerHTML ─────────────────────────────
function runInjectedScripts(container) {
    container.querySelectorAll('script').forEach(oldScript => {
        const newScript = document.createElement('script');
        Array.from(oldScript.attributes).forEach(attr => {
            newScript.setAttribute(attr.name, attr.value);
        });
        newScript.textContent = oldScript.textContent;
        document.body.appendChild(newScript);
        document.body.removeChild(newScript);
    });
}

async function loadSection(url) {
    if (!url.startsWith('/') && !url.startsWith('http')) {
        url = '/views/' + url;
    }

    const currentContent = document.querySelector('.main__content');
    if (currentContent) currentContent.style.opacity = '0.5';

    try {
        const response = await fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!response.ok) throw new Error('Error al cargar la página');
        const html = await response.text();

        if (currentContent) {
            currentContent.innerHTML = html;
            currentContent.style.opacity = '1';
            window.history.pushState({}, '', url);
            initDynamicContent();
            runInjectedScripts(currentContent);
        }
    } catch (error) {
        console.error('Error cargando la sección:', error);
        window.location.href = url;
    }
}

// ── Mostrar más / menos ───────────────────────────────────────────────────
function toggleTexto(button) {
    const contenedorTexto = button.previousElementSibling;
    button.classList.toggle('expandido');
    contenedorTexto.classList.toggle('expandido');
    button.textContent = button.classList.contains('expandido') ? 'Mostrar menos' : 'Mostrar más';
}

function initMostrarMas() {
    document.querySelectorAll('.contenido__texto').forEach(contenedor => {
        const parrafo = contenedor.querySelector('p');
        if (!parrafo) return;
        const alturaLinea = parseInt(getComputedStyle(parrafo).lineHeight);
        const alturaMaxima = alturaLinea * 5;
        if (parrafo.scrollHeight > alturaMaxima) {
            contenedor.classList.add('necesita__expandir');
        }
    });
}

// ── Buscador (explorar y mensajes) ────────────────────────────────────────
function initBuscador() {
    const buscador      = document.getElementById('buscador');
    const listaUsuarios = document.getElementById('lista-usuarios');

    if (buscador && listaUsuarios) {
        const originales = Array.from(listaUsuarios.querySelectorAll('.usuario-item'));

        buscador.focus();
        buscador.addEventListener('input', function () {
            const texto = this.value.toLowerCase().trim();
            listaUsuarios.innerHTML = '';

            const filtrados = texto === ''
                ? originales
                : originales.filter(u => {
                    const nombre = u.querySelector('.nombre-usuario');
                    return nombre && nombre.textContent.toLowerCase().includes(texto);
                });

            if (filtrados.length > 0) {
                filtrados.forEach(u => listaUsuarios.appendChild(u));
            } else {
                const msg = document.createElement('p');
                msg.className = 'no-resultados';
                msg.textContent = 'No se encontraron usuarios con ese nombre';
                listaUsuarios.appendChild(msg);
            }
        });
        return;
    }

    const mensajesDiv = document.querySelector('.mensajes');
    if (buscador && mensajesDiv) {
        const botones = Array.from(mensajesDiv.querySelectorAll('.mensajes__usuarios'));

        buscador.addEventListener('input', function () {
            const texto = this.value.toLowerCase().trim();
            botones.forEach(btn => {
                const nombre = btn.querySelector('p');
                const visible = !texto || (nombre && nombre.textContent.toLowerCase().includes(texto));
                btn.style.display = visible ? '' : 'none';
            });
        });
    }
}

// ── Seguir usuario ────────────────────────────────────────────────────────
function initSeguir() {
    const btn = document.getElementById('btn-seguir');
    if (!btn) return;

    btn.addEventListener('click', function () {
        const username = this.dataset.username;
        fetch('/controllers/verUsuario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'accion=seguir&username_a_seguir=' + encodeURIComponent(username)
        })
            .then(r => r.text())
            .then(() => {
                btn.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/1828/1828817.png"><p class="btn-texto">Siguiendo ✓</p>';
                btn.disabled = true;
                btn.style.opacity = '0.7';
            })
            .catch(err => console.error('Error seguir:', err));
    });
}

// ── Likes / Dislikes ──────────────────────────────────────────────────────
function initLikes() {
    const content = document.querySelector('.main__content');
    if (!content || content.dataset.likesInit) return;
    content.dataset.likesInit = '1';

    content.addEventListener('click', function (e) {
        const btnLike    = e.target.closest('.post__valoraciones__likes');
        const btnDislike = e.target.closest('.post__valoraciones__dislikes');
        if (!btnLike && !btnDislike) return;

        const btn    = btnLike || btnDislike;
        const accion = btnLike ? 'like' : 'dislike';
        const postId = btn.dataset.idPost;
        if (!postId) return;

        btn.disabled = true;
        const body = new FormData();
        body.append('post_id', postId);
        body.append('accion',  accion);

        fetch('/controllers/likes.php', { method: 'POST', body })
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                const cont = btn.closest('.post__valoraciones');
                const btnL = cont.querySelector('.post__valoraciones__likes');
                const btnD = cont.querySelector('.post__valoraciones__dislikes');
                btnL.querySelector('p').textContent = data.likes;
                btnD.querySelector('p').textContent = data.dislikes;
                btnL.classList.toggle('activo', data.voto === 'like');
                btnD.classList.toggle('activo', data.voto === 'dislike');
            })
            .catch(err => console.error('Error likes:', err))
            .finally(() => { btn.disabled = false; });
    });
}

// ── Arranque ──────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    initDynamicContent();

    window.addEventListener('popstate', () => {
        window.location.reload();
    });
});
