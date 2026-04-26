<?php 
    require_once "../controllers/logros.php";
    require_once "../models/TablaMisiones.php";

    $usuario_id = $_SESSION["id"] ?? null;
    $misiones = $usuario_id 
        ? mostrarMisionesConEstado($conexion, $usuario_id)
        : mostrarMisiones($conexion);

    $dificultad_labels = [
        'facil'      => ['label' => 'Fácil',      'color' => '#17bf63'],
        'normal'     => ['label' => 'Normal',      'color' => '#1d9bf0'],
        'dificil'    => ['label' => 'Difícil',     'color' => '#f4a118'],
        'epico'      => ['label' => 'Épico',       'color' => '#9c01c0'],
        'legendario' => ['label' => 'Legendario',  'color' => '#fc204c'],
    ];
?>

<div class="logros">
    <h1>Mis misiones</h1>

    <div class="misiones__stats">
        <?php
            $completadas = 0; $pendientes = 0; $sin_recoger = 0;
            foreach ($misiones as $m) {
                if ($m['fecha_completado']) {
                    $completadas++;
                    if (!$m['recompensa_recogida']) $sin_recoger++;
                } else {
                    $pendientes++;
                }
            }
        ?>
        <div class="misiones__stat">
            <span class="misiones__stat__num"><?php echo $completadas; ?></span>
            <span class="misiones__stat__label">Completadas</span>
        </div>
        <div class="misiones__stat">
            <span class="misiones__stat__num"><?php echo $pendientes; ?></span>
            <span class="misiones__stat__label">Pendientes</span>
        </div>
        <?php if ($sin_recoger > 0): ?>
        <div class="misiones__stat misiones__stat--pendiente">
            <span class="misiones__stat__num"><?php echo $sin_recoger; ?></span>
            <span class="misiones__stat__label">Sin recoger</span>
        </div>
        <?php endif; ?>
    </div>

    <div class="logros__misiones">
        <?php foreach($misiones as $m):
            $completada       = !empty($m['fecha_completado']);
            $recompensa_ok    = $completada && $m['recompensa_recogida'];
            $pendiente_recoger= $completada && !$m['recompensa_recogida'];
            $dif              = $m['dificultad'] ?? 'facil';
            $dif_info         = $dificultad_labels[$dif] ?? $dificultad_labels['facil'];
            $puntos           = $m['puntos'] ?? 0;
        ?>
            <div class="logros__misiones__mision <?php echo $completada ? ($recompensa_ok ? 'recogida' : 'completado') : ''; ?>">

                <span class="mision__dificultad" style="color:<?php echo $dif_info['color']; ?>; border-color:<?php echo $dif_info['color']; ?>20;">
                    <?php echo $dif_info['label']; ?>
                </span>

                <img src="<?php echo htmlspecialchars($m['icono']); ?>" alt="<?php echo htmlspecialchars($m['nombre']); ?>">

                <p><?php echo htmlspecialchars($m['nombre']); ?></p>
                <a><?php echo htmlspecialchars($m['descripcion']); ?></a>

                <div class="mision__recompensa">
                    <img src="https://cdn-icons-png.flaticon.com/128/846/846061.png" class="mision__moneda__icon">
                    <span><?php echo $puntos; ?> MRTNs</span>
                </div>

                <?php if ($recompensa_ok): ?>
                    <button class="btn__mision btn__mision--recogida" disabled>
                        <img src="https://cdn-icons-png.flaticon.com/128/1828/1828817.png">
                        Recompensa recogida
                    </button>
                <?php elseif ($pendiente_recoger): ?>
                    <button class="btn__mision btn__mision--recoger"
                            data-logro-id="<?php echo htmlspecialchars($m['id']); ?>"
                            onclick="recogerRecompensa(this)">
                        <img src="https://cdn-icons-png.flaticon.com/128/846/846061.png">
                        Recoger recompensa
                    </button>
                <?php else: ?>
                    <button class="btn__mision btn__mision--pendiente" disabled>
                        Pendiente
                    </button>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Toast de recompensa -->
<div id="toast__recompensa" class="toast__recompensa" style="display:none;">
    <img src="https://cdn-icons-png.flaticon.com/128/846/846061.png">
    <div>
        <strong>¡Recompensa recogida!</strong>
        <p id="toast__recompensa__texto"></p>
    </div>
</div>

<script>
function recogerRecompensa(btn) {
    var logroId = btn.getAttribute('data-logro-id');
    btn.disabled = true;
    btn.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/846/846061.png"> Recogiendo...';

    fetch('/controllers/notificaciones.php?accion=recoger_recompensa', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'accion=recoger_recompensa&logro_id=' + encodeURIComponent(logroId)
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.success) {
            var card = btn.closest('.logros__misiones__mision');
            card.classList.remove('completado');
            card.classList.add('recogida');
            btn.className = 'btn__mision btn__mision--recogida';
            btn.disabled = true;
            btn.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/1828/1828817.png"> Recompensa recogida';

            // Actualizar el contador "Sin recoger" del DOM
            var statPendiente = document.querySelector('.misiones__stat--pendiente .misiones__stat__num');
            if (statPendiente) {
                var actual = parseInt(statPendiente.textContent) - 1;
                if (actual <= 0) {
                    statPendiente.closest('.misiones__stat--pendiente').remove();
                } else {
                    statPendiente.textContent = actual;
                }
            }

            // Mostrar toast
            var toast = document.getElementById('toast__recompensa');
            document.getElementById('toast__recompensa__texto').textContent = '+' + data.puntos + ' MRTNs añadidos a tu saldo';
            toast.style.display = 'flex';
            setTimeout(function() { toast.style.display = 'none'; }, 3500);
        } else {
            btn.disabled = false;
            btn.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/846/846061.png"> Recoger recompensa';
            alert(data.error || 'Error al recoger la recompensa');
        }
    })
    .catch(function(err) {
        console.error(err);
        btn.disabled = false;
        btn.innerHTML = '<img src="https://cdn-icons-png.flaticon.com/128/846/846061.png"> Recoger recompensa';
    });
}
</script>
