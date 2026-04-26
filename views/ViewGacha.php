<?php 
    require_once "../controllers/gacha.php";
?>

<div class="gacha__page">

    <!-- ══════════════════════════════════════════════
         SECCIÓN: RECOMPENSAS (banners + cursores)
    ════════════════════════════════════════════════ -->
    <h1 class="gacha__page__title">Mi Colección</h1>

    <!-- ── BANNERS ───────────────────────────────── -->
    <div class="coleccion__bloque" id="bloque-banners">
        <button class="coleccion__toggle" id="toggle-banners" aria-expanded="true">
            <span class="coleccion__toggle__icon">🖼️</span>
            <span class="coleccion__toggle__label">Banners</span>
            <span class="coleccion__toggle__count">
                <?php echo count($itemsUsuario ?? []); ?> obtenidos
            </span>
            <span class="coleccion__toggle__chevron">▲</span>
        </button>

        <div class="coleccion__contenido" id="contenido-banners">
            <?php 
            $totalItems = count($itemsUsuario ?? []);
            if ($totalItems > 0): ?>
                <div class="gacha-container">
                    <?php foreach ($itemsUsuario as $i): 
                        $rareza           = htmlspecialchars($i['rareza'] ?? 'comun');
                        $nombre           = htmlspecialchars($i['nombre_imagen'] ?? '');
                        $nombreSinExt     = pathinfo($nombre, PATHINFO_FILENAME);
                        $nombreFormateado = ucwords(str_replace('_', ' ', $nombreSinExt));
                    ?>
                    <div class="gacha_imagen">
                        <div class="image-wrapper">
                            <span class="rarity-badge <?php echo $rareza; ?>">
                                <?php echo $rareza; ?>
                            </span>
                            <img src="../img/coleccionables/<?php echo $rareza; ?>/<?php echo $nombre; ?>"
                                 alt="<?php echo $nombreFormateado; ?>"
                                 onerror="this.src='../img/default_banner.jpg'">
                        </div>
                        <div class="item-info">
                            <span class="item-name" title="<?php echo $nombreFormateado; ?>">
                                <?php echo $nombreFormateado; ?>
                            </span>
                            <button class="añadir__banner" data-banner="<?php echo $nombre; ?>">Añadir Banner</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-items-container no-items-container--inline">
                    <div class="icon">🖼️</div>
                    <p>Aún no tienes ningún banner. ¡Tira el gacha!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── CURSORES ───────────────────────────────── -->
    <div class="coleccion__bloque" id="bloque-cursores">
        <button class="coleccion__toggle" id="toggle-cursores" aria-expanded="true">
            <span class="coleccion__toggle__icon">🖱️</span>
            <span class="coleccion__toggle__label">Cursores</span>
            <span class="coleccion__toggle__count">
                <?php echo count($misCursores ?? []); ?> obtenidos
            </span>
            <span class="coleccion__toggle__chevron">▲</span>
        </button>

        <div class="coleccion__contenido" id="contenido-cursores">
            <?php if (!empty($misCursores)): ?>
                <div class="cursores__container">
                    <div class="cursor__card <?php echo (!$cursorActivo ? 'cursor__card--activo' : ''); ?>" data-cursor="">
                        <div class="cursor__preview cursor__preview--default">
                            <span style="font-size:28px;">↖</span>
                        </div>
                        <div class="cursor__info">
                            <span class="cursor__nombre">Por defecto</span>
                            <span class="rarity-badge comun">común</span>
                        </div>
                        <button class="cursor__btn <?php echo (!$cursorActivo ? 'cursor__btn--equipado' : ''); ?>"
                                data-cursor=""
                                <?php echo (!$cursorActivo ? 'disabled' : ''); ?>>
                            <?php echo (!$cursorActivo ? '✓ Equipado' : 'Equipar'); ?>
                        </button>
                    </div>

                    <?php foreach ($misCursores as $c):
                        $nc     = htmlspecialchars($c['nombre_cursor']);
                        $rz     = htmlspecialchars($c['rareza']);
                        $nombre = str_replace(['cursor_', '.svg'], ['', ''], $nc);
                        $nombre = ucwords(str_replace('_', ' ', $nombre));
                        $activo = ($cursorActivo === $nc);
                    ?>
                    <div class="cursor__card <?php echo ($activo ? 'cursor__card--activo' : ''); ?> cursor__card--<?php echo $rz; ?>"
                         data-cursor="<?php echo $nc; ?>">
                        <div class="cursor__preview">
                            <img src="/img/cursores/<?php echo $nc; ?>" alt="<?php echo $nombre; ?>">
                        </div>
                        <div class="cursor__info">
                            <span class="cursor__nombre"><?php echo $nombre; ?></span>
                            <span class="rarity-badge <?php echo $rz; ?>"><?php echo $rz; ?></span>
                        </div>
                        <button class="cursor__btn <?php echo ($activo ? 'cursor__btn--equipado' : ''); ?>"
                                data-cursor="<?php echo $nc; ?>"
                                <?php echo ($activo ? 'disabled' : ''); ?>>
                            <?php echo ($activo ? '✓ Equipado' : 'Equipar'); ?>
                        </button>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="no-items-container no-items-container--inline">
                    <div class="icon">🖱️</div>
                    <p>Aún no tienes ningún cursor personalizado. ¡Tira el gacha!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════
         SECCIÓN: BOTÓN GACHA + INFO
    ════════════════════════════════════════════════ -->
    <div class="gacha__accion">
        <div class="gacha__accion__fila">
            <button class="btn__tirar__gacha" id="tirarGacha">
                Tirar Gacha <span class="gacha__coste">🪙 10</span>
            </button>
            <button class="btn__info__gacha" id="btnInfoGacha" title="¿Qué puedo conseguir?">?</button>
        </div>

        <!-- Popup de información -->
        <div class="gacha__info__popup" id="gachaInfoPopup">
          <div class="gacha__info__popup__inner">
            <button class="gacha__info__popup__cerrar" id="cerrarInfoGacha">✕</button>
            <h3>¿Qué es el Gacha?</h3>
            <p>
                Con el Gacha puedes obtener <strong>personalizables exclusivos</strong> para tu perfil:
                <strong>banners</strong> que decoran tu fondo de perfil y <strong>cursores</strong>
                personalizados que cambian el puntero en toda la app.
            </p>
            <p class="gacha__info__mrtn">
                💡 Para conseguir <strong>MRTNs</strong> (la moneda del gacha) debes completar
                las <strong>misiones</strong> que se especifican en el apartado de <em>Misiones</em>.
            </p>

            <h4>Probabilidades</h4>
            <table class="gacha__tabla__odds">
                <thead>
                    <tr>
                        <th>Rareza</th>
                        <th>Tipo</th>
                        <th>Probabilidad</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="odds--comun">
                        <td><span class="rarity-badge comun">Común</span></td>
                        <td>Banner / Cursor</td>
                        <td>60%</td>
                    </tr>
                    <tr class="odds--raro">
                        <td><span class="rarity-badge raro">Raro</span></td>
                        <td>Banner / Cursor</td>
                        <td>25%</td>
                    </tr>
                    <tr class="odds--epico">
                        <td><span class="rarity-badge épico">Épico</span></td>
                        <td>Banner / Cursor</td>
                        <td>12%</td>
                    </tr>
                    <tr class="odds--legendario">
                        <td><span class="rarity-badge legendario">Legendario</span></td>
                        <td>Banner / Cursor</td>
                        <td>3%</td>
                    </tr>
                </tbody>
            </table>

            <p class="gacha__info__nota">
                ⚠️ Si ya posees el objeto obtenido, se marcará como duplicado pero seguirá sumando a tu colección.
            </p>
          </div><!-- /.gacha__info__popup__inner -->
        </div>
    </div>

</div><!-- /.gacha__page -->

<!-- ══════════════════════════════════════════════
     OVERLAY ANIMACIÓN GACHA
════════════════════════════════════════════════ -->
<div id="gacha__overlay" class="gacha__overlay" style="display:none;">
    <div class="gacha__overlay__box">
        <div class="gacha__particles" id="gacha__particles"></div>
        <div class="gacha__glow" id="gacha__glow"></div>

        <div class="gacha__card" id="gacha__card">
            <div class="gacha__card__inner">
                <div class="gacha__card__front">
                    <div class="gacha__card__question">?</div>
                </div>
                <div class="gacha__card__back" id="gacha__card__back">
                    <img id="gacha__result__img" src="" alt="">
                    <div class="gacha__result__rareza" id="gacha__result__rareza"></div>
                </div>
            </div>
        </div>

        <div class="gacha__result__info" id="gacha__result__info" style="display:none;">
            <p class="gacha__result__tipo" id="gacha__result__tipo" style="display:none;"></p>
            <p class="gacha__result__nombre" id="gacha__result__nombre"></p>
            <p class="gacha__result__repetida" id="gacha__result__repetida" style="display:none;">⚠️ ¡Ya tenías este!</p>
            <button class="gacha__btn__cerrar" id="gacha__btn__cerrar">¡Genial!</button>
        </div>
    </div>
</div>

<script>
(function () {

    /* ── Toggle colecciones ─────────────────────── */
    ['banners', 'cursores'].forEach(function (id) {
        var btn       = document.getElementById('toggle-' + id);
        var contenido = document.getElementById('contenido-' + id);
        if (!btn || !contenido) return;

        btn.addEventListener('click', function () {
            var abierto = btn.getAttribute('aria-expanded') === 'true';
            btn.setAttribute('aria-expanded', String(!abierto));
            var chevron = btn.querySelector('.coleccion__toggle__chevron');

            if (abierto) {
                /* cerrar */
                contenido.style.maxHeight = contenido.scrollHeight + 'px';
                requestAnimationFrame(function () {
                    contenido.style.maxHeight = '0';
                    contenido.style.opacity   = '0';
                });
                if (chevron) chevron.textContent = '▼';
            } else {
                /* abrir */
                contenido.style.maxHeight = contenido.scrollHeight + 'px';
                contenido.style.opacity   = '1';
                if (chevron) chevron.textContent = '▲';
                contenido.addEventListener('transitionend', function handler() {
                    contenido.style.maxHeight = 'none';
                    contenido.removeEventListener('transitionend', handler);
                });
            }
        });
    });

    /* ── Popup info gacha ───────────────────────── */
    var btnInfo   = document.getElementById('btnInfoGacha');
    var popup     = document.getElementById('gachaInfoPopup');
    var cerrarBtn = document.getElementById('cerrarInfoGacha');

    btnInfo.addEventListener('click', function (e) {
        e.stopPropagation();
        popup.classList.toggle('gacha__info__popup--visible');
    });

    cerrarBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        popup.classList.remove('gacha__info__popup--visible');
    });

    document.addEventListener('click', function (e) {
        if (popup.classList.contains('gacha__info__popup--visible') &&
            !e.target.closest('.gacha__info__popup__inner') &&
            e.target !== btnInfo) {
            popup.classList.remove('gacha__info__popup--visible');
        }
    });

    /* ── Partículas ─────────────────────────────── */
    function lanzarParticulas(rareza) {
        var container = document.getElementById('gacha__particles');
        container.innerHTML = '';
        var colors = {
            comun:      ['#aaa','#ccc','#eee'],
            epico:      ['#9c01c0','#c44dff','#e0aaff'],
            legendario: ['#ffd700','#ffec6e','#fffacd']
        };
        var palette = colors[rareza] || colors.comun;
        for (var i = 0; i < 40; i++) {
            var p = document.createElement('div');
            p.className = 'gacha__particle';
            p.style.cssText = [
                'left:'   + Math.random() * 100 + '%',
                'background:' + palette[Math.floor(Math.random() * palette.length)],
                'animation-delay:' + (Math.random() * 0.6) + 's',
                'animation-duration:' + (0.8 + Math.random() * 0.8) + 's',
                'width:'  + (4 + Math.random() * 6) + 'px',
                'height:' + (4 + Math.random() * 6) + 'px'
            ].join(';');
            container.appendChild(p);
        }
    }

    /* ── Mostrar overlay ────────────────────────── */
    function mostrarResultado(data) {
        var overlay  = document.getElementById('gacha__overlay');
        var card     = document.getElementById('gacha__card');
        var glow     = document.getElementById('gacha__glow');
        var img      = document.getElementById('gacha__result__img');
        var rarezaEl = document.getElementById('gacha__result__rareza');
        var nombreEl = document.getElementById('gacha__result__nombre');
        var tipoEl   = document.getElementById('gacha__result__tipo');
        var repEl    = document.getElementById('gacha__result__repetida');
        var infoEl   = document.getElementById('gacha__result__info');

        card.classList.remove('gacha__card--flip');
        glow.className       = 'gacha__glow';
        infoEl.style.display = 'none';
        repEl.style.display  = 'none';

        if (data.tipo === 'cursor') {
            img.src              = '/img/cursores/' + data.nombre;
            img.style.objectFit  = 'contain';
            img.style.padding    = '30px';
            img.style.background = '#0a0a1a';
            tipoEl.textContent   = '🖱️ ¡Nuevo cursor!';
            tipoEl.style.display = 'block';
        } else {
            img.src              = '/img/coleccionables/' + data.rareza + '/' + data.nombre;
            img.style.objectFit  = 'cover';
            img.style.padding    = '0';
            img.style.background = '#111';
            tipoEl.style.display = 'none';
        }

        rarezaEl.textContent = data.rareza.toUpperCase();
        rarezaEl.className   = 'gacha__result__rareza rareza--' + data.rareza;

        var nombreLimpio = data.nombre
            .replace(/\.[^.]+$/, '')
            .replace(/^cursor_/, '')
            .replace(/_/g, ' ');
        nombreEl.textContent = nombreLimpio.charAt(0).toUpperCase() + nombreLimpio.slice(1);

        if (data.repetida) repEl.style.display = 'block';

        overlay.style.display = 'flex';
        void overlay.offsetWidth;
        overlay.classList.add('gacha__overlay--visible');

        setTimeout(function () {
            card.classList.add('gacha__card--flip');
            glow.classList.add('gacha__glow--' + data.rareza);
            lanzarParticulas(data.rareza);
            setTimeout(function () { infoEl.style.display = 'flex'; }, 700);
        }, 600);
    }

    /* ── Cerrar overlay ─────────────────────────── */
    document.getElementById('gacha__btn__cerrar').addEventListener('click', function () {
        var overlay = document.getElementById('gacha__overlay');
        overlay.classList.remove('gacha__overlay--visible');
        setTimeout(function () {
            overlay.style.display = 'none';
            loadSection('ViewGacha.php');
        }, 300);
    });

    /* ── Tirar gacha ────────────────────────────── */
    document.getElementById('tirarGacha').addEventListener('click', function () {
        var btn = this;
        btn.disabled    = true;
        btn.textContent = 'Tirando...';

        fetch('/controllers/gacha.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'accion=tirarGacha'
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                mostrarResultado(data);
            } else {
                var err = document.createElement('p');
                err.className   = 'gacha__error__msg';
                err.textContent = data.message || 'Error al tirar el gacha.';
                btn.parentNode.insertBefore(err, btn);
                setTimeout(function () { err.remove(); }, 4000);
            }
            btn.disabled  = false;
            btn.innerHTML = 'Tirar Gacha <span class="gacha__coste">🪙 10</span>';
        })
        .catch(function () {
            btn.disabled  = false;
            btn.innerHTML = 'Tirar Gacha <span class="gacha__coste">🪙 10</span>';
        });
    });

    /* ── Equipar cursor ─────────────────────────── */
    document.querySelectorAll('.cursor__btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var nombreCursor = this.dataset.cursor;
            var accion = nombreCursor ? 'equiparCursor' : 'quitarCursor';
            var body   = 'accion=' + accion;
            if (nombreCursor) body += '&nombre_cursor=' + encodeURIComponent(nombreCursor);

            fetch('/controllers/gacha.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    if (window.aplicarCursorActivo) window.aplicarCursorActivo(nombreCursor || null);
                    loadSection('ViewGacha.php');
                }
            });
        });
    });

    /* ── Preview cursor al hover ────────────────── */
    document.querySelectorAll('.cursor__card').forEach(function (card) {
        var nc = card.dataset.cursor;
        card.addEventListener('mouseenter', function () {
            document.body.style.cursor = nc
                ? 'url(/img/cursores/' + nc + ') 0 0, auto'
                : '';
        });
        card.addEventListener('mouseleave', function () {
            var activo = document.documentElement.style.getPropertyValue('--cursor-activo');
            document.body.style.cursor = activo || '';
        });
    });

    /* ── Añadir banner ──────────────────────────── */
    document.querySelectorAll('.añadir__banner').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var nombre_imagen = this.dataset.banner;
            fetch('/controllers/gacha.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'accion=banner&nombre_imagen=' + encodeURIComponent(nombre_imagen)
            })
            .then(function () { loadSection('formMenu.php'); })
            .catch(function () { alert('Error al añadir el banner.'); });
        });
    });

})();
</script>