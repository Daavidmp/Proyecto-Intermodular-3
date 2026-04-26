<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    require_once __DIR__ . '/../models/conexionDatabase.php';
    require_once __DIR__ . '/../models/TablaMisiones.php';

    $conexion_sb  = conexion();
    $uid_sb       = $_SESSION['id'] ?? null;
    $sin_leer_sb  = $uid_sb ? contarNotificacionesSinLeer($conexion_sb, $uid_sb) : 0;
?>
<div class="sidebar">
    <h1 class="titulo">MRTN</h1>
    <button class="sidebar__inicio" data-url="ViewPosts.php">
        <img src="https://cdn-icons-png.flaticon.com/128/25/25694.png">
        <p>Inicio</p>
    </button>
    <button class="sidebar__buscar" id="btn__explorar" data-url="formExplorar.php">
        <img src="https://cdn-icons-png.flaticon.com/512/2319/2319177.png">
        <p>Explorar</p>
    </button>
    <button class="sidebar__notificaciones" data-url="ViewNotificaciones.php" style="position:relative;">
        <img src="https://cdn-icons-png.flaticon.com/128/4991/4991422.png">
        <p>Notificaciones</p>
        <?php if ($sin_leer_sb > 0): ?>
            <span class="notif__badge" id="notif__badge"><?php echo min($sin_leer_sb, 99); ?></span>
        <?php else: ?>
            <span class="notif__badge notif__badge--hidden" id="notif__badge"></span>
        <?php endif; ?>
    </button>
    <button class="sidebar__mensajes" data-url="ViewMensajes.php">
        <img src="https://cdn-icons-png.flaticon.com/128/520/520648.png">
        <p>Mensajes</p>
    </button>
    <button class="sidebar__perfil" id="btn__perfil" data-url="formMenu.php">
        <img src="https://cdn-icons-png.flaticon.com/128/9308/9308015.png">
        <p>Perfil</p>
    </button>
    <button class="sidebar__logros" data-url="ViewMisiones.php">
        <img src="https://cdn-icons-png.flaticon.com/128/8527/8527971.png">
        <p>Mis misiones</p>
    </button>
    <button class="sidebar__monedas" data-url="ViewComprarMonedas.php">
        <img src="https://cdn-icons-png.flaticon.com/512/846/846061.png">
        <p>Comprar Monedas</p>
    </button>
    <button class="cerrar__sesion" onclick="window.location.href = '/controllers/cerrarSesion.php'">
        <img src="https://cdn-icons-png.flaticon.com/512/660/660350.png">
        <p>Cerrar Sesión</p>
    </button>
</div>