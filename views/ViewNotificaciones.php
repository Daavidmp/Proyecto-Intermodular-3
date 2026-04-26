<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    require_once "../models/conexionDatabase.php";
    require_once "../models/TablaMisiones.php";

    $conexion   = conexion();
    $usuario_id = $_SESSION["id"] ?? null;

    $notificaciones = [];
    if ($usuario_id) {
        $notificaciones = obtenerNotificaciones($conexion, $usuario_id);
        marcarNotificacionesLeidas($conexion, $usuario_id);
    }
?>

<div class="notificaciones">
    <h1>Notificaciones</h1>

    <?php if (empty($notificaciones)): ?>
        <div class="notificaciones__vacio">
            <img src="https://cdn-icons-png.flaticon.com/128/4991/4991422.png">
            <p>No tienes notificaciones aún</p>
        </div>
    <?php else: ?>
        <div class="notificaciones__lista">
            <?php foreach ($notificaciones as $n): 
                $leida = $n['leida'] ? 'leida' : 'no-leida';
            ?>
                <div class="notificacion__item <?php echo $leida; ?> notificacion__<?php echo $n['tipo']; ?>">

                    <?php if ($n['tipo'] === 'mensaje'): ?>
                        <div class="notificacion__icono notificacion__icono--mensaje">
                            <?php if (!empty($n['emisor_avatar'])): ?>
                                <img src="<?php echo htmlspecialchars($n['emisor_avatar']); ?>" class="notificacion__avatar">
                            <?php else: ?>
                                <img src="https://cdn-icons-png.flaticon.com/128/520/520648.png">
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="notificacion__icono notificacion__icono--mision">
                            <img src="https://cdn-icons-png.flaticon.com/128/8527/8527971.png">
                        </div>
                    <?php endif; ?>

                    <div class="notificacion__contenido">
                        <strong><?php echo htmlspecialchars($n['titulo']); ?></strong>
                        <p><?php echo htmlspecialchars($n['descripcion']); ?></p>
                        <span class="notificacion__fecha">
                            <?php
                                date_default_timezone_set('Europe/Madrid');
                                $fecha = new DateTime($n['fecha']);
                                $ahora = new DateTime();
                                $diff  = $ahora->diff($fecha);
                                if ($diff->days > 0)      echo 'hace ' . $diff->days . 'd';
                                elseif ($diff->h > 0)     echo 'hace ' . $diff->h . 'h';
                                elseif ($diff->i > 0)     echo 'hace ' . $diff->i . 'min';
                                else                      echo 'ahora';
                            ?>
                        </span>
                    </div>

                    <div class="notificacion__accion">
                        <?php if ($n['tipo'] === 'mision'): ?>
                            <button class="notif__btn notif__btn--mision"
                                    onclick="loadSection('ViewMisiones.php')">
                                Ver misiones
                            </button>
                        <?php elseif ($n['tipo'] === 'mensaje' && !empty($n['dato_extra'])): ?>
                            <button class="notif__btn notif__btn--chat"
                                    onclick="loadSection('ViewChat.php?receptor_id=<?php echo htmlspecialchars($n['dato_extra']); ?>')">
                                Ir al chat
                            </button>
                        <?php endif; ?>
                    </div>

                    <?php if (!$n['leida']): ?>
                        <span class="notificacion__punto"></span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
