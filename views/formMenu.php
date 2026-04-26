<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    require_once "../controllers/menu.php";
    require_once "../models/TablaPosts.php";
    require_once "../models/TablaSeguidores.php";
    require_once "../controllers/gacha.php";

    $usuario  = $_SESSION["username"];
    $conexion = conexion();

    $postDeMiUsuario = mostrarPostsDeUnUsuario($conexion, $usuario);
    $postIdsMenu     = array_column($postDeMiUsuario, 'id');
    $votosUsuario    = obtenerVotosUsuarioEnPosts($conexion, $_SESSION['id'], $postIdsMenu);

    // FIX #7: usamos obtenerDatos() para sacar el id y llamar a las funciones
    // correctas sin depender de las obsoletas obtenerSiguiendo/obtenerSeguidores
    $datosPerfil  = obtenerDatos($conexion);
    $uid_menu     = $datosPerfil['id'] ?? null;
    $totalSiguiendo  = $uid_menu ? obtenerSiguiendoUsuario($conexion, $uid_menu)  : 0;
    $totalSeguidores = $uid_menu ? obtenerSeguidoresUsuario($conexion, $uid_menu) : 0;
?>
<div class="main__content__section1">
    <img class="main__content__section1__flecha" src="../img/flecha.png">
    <div class="profile-header-info">
        <h1 class="profile-name"><?php echo $usuario; ?></h1>
        <div class="profile-header-info-stats">
            <span class="post-count"><?php echo $postsTotales . " posts"?></span>
            <span class="post-count"><?php echo "Saldo: " . $saldoTotal . " MRTNs"?></span>
        </div>
    </div>
</div>
<div class="containers">
    <div class="banner">
        <?php if(!empty($miBanner["banner"]) && !empty($miBanner["rareza"])): ?>
            <img src="../img/coleccionables/<?php echo htmlspecialchars($miBanner["rareza"]); ?>/<?php echo htmlspecialchars($miBanner["banner"]); ?>"
                onerror="this.src='../img/banner-default.jpg'">
        <?php else: ?>
            <img src="../img/bannerejemplo.jpg" alt="Banner por defecto">
        <?php endif; ?>
    </div>
    <div class="img__perfil">
        <img src="<?php echo $avatar_url?>" onerror="this.src='../img/iconodefault.jpg'">
    </div>
</div>
<div class="main__content__section2">
    <button class="btn__gacha" data-tooltip="Obten un elemento personalizado por 10 MRTNs" onclick="loadSection('ViewGacha.php')">
        <img src="https://cdn-icons-png.flaticon.com/128/992/992651.png">
    </button>
    <button class="btn-compartir">
        <img src="https://cdn-icons-png.flaticon.com/128/3832/3832624.png">
    </button>
    <button class="btn-trespuntos">
        <img src="https://cdn-icons-png.flaticon.com/128/512/512142.png">
    </button>
    <!-- FIX #9: eliminado onclick inline duplicado, sidebar.js ya lo gestiona -->
    <button class="btn-config" id="btn__editar">
        <img src="https://cdn-icons-png.flaticon.com/128/1242/1242494.png">
        <p class="btn-texto">Editar perfil</p>
    </button>
</div>
<hr>
<div class="main__content__section3">
    <div class="nombre__tag">
        <p class="nombre__tag__usuario"><?php echo $usuario?></p>
        <p class="nombre__tag__tag">@<?php echo $usuario?></p>
    </div>
</div>
<hr>
<div class="main__content__section4">
    <p><?php echo $biografia?></p>
</div>
<hr>
<div class="main__content__section5">
    <p class="main__content__section5__ubi"><?php echo $ubicacion?></p>
    <a href="<?php echo $enlace_spoty?>" class="main__content__section5__spoty"><?php echo $usuario . ".com"?></a>
    <p class="main__content__section5__fecha">
        <?php
            $dt = new DateTime($fecha);
            echo "Se unió: " . $dt->format('m/Y');
        ?>
    </p>
</div>
<div class="main__content__section6">
    <p class="main__content__section6__espacio"><img src="https://cdn-icons-png.flaticon.com/128/651/651717.png"><?php echo "<b>" . $postsTotales . "</b>" . " Posts"?></p>
    <!-- FIX #4 #7: usando funciones correctas con id explícito -->
    <p><?php echo "<b>" . $totalSiguiendo . "</b>" . " Siguiendo"?></p>
    <p><?php echo "<b>" . $totalSeguidores . "</b>" . " Seguidores"?></p>
    <button onclick="loadSection('ViewCrearPosts.php')">Añadir Post</button>
</div>
<div class="main__content__section7">
    <h1>Posts</h1>
    <div class="contenido__posts">
        <?php foreach($postDeMiUsuario as $posts): ?>
            <div class="post__container">
                <div class="post__columna__izquierda">
                    <div class="post__avatar">
                        <img src="<?php echo $avatar_url; ?>">
                        <p><?php echo $usuario ?></p>
                    </div>

                    <div class="contenido__texto">
                        <p><?php echo $posts["contenido"] ?></p>
                    </div>

                    <button class="mostrar__mas__btn" onclick="toggleTexto(this)">
                        Mostrar más
                    </button>
                </div>

                <div class="post__valoraciones">
                    <?php $voto = $votosUsuario[$posts['id']] ?? null; ?>
                    <button class="post__valoraciones__likes <?php echo $voto === 'like' ? 'activo' : ''; ?>" data-id-post="<?php echo $posts['id'] ?>">
                        <img src="https://cdn-icons-png.flaticon.com/128/9513/9513802.png">
                        <p><?php echo $posts["likes"]?></p>
                    </button>
                    <button class="post__valoraciones__dislikes <?php echo $voto === 'dislike' ? 'activo' : ''; ?>" data-id-post="<?php echo $posts['id'] ?>">
                        <img src="https://cdn-icons-png.flaticon.com/128/880/880613.png">
                        <p><?php echo $posts["dislikes"]?></p>
                    </button>
                </div>

                <div class="post__columna__derecha">
                    <a href="<?php echo $posts["music_link"] ?>" class="post__music__link" target="_blank">
                        <img class="post__music__image" src="<?php echo $posts["image_link"] ?>" alt="Portada de música">
                        <div class="post__music__badge">
                            <span>🎵</span>
                            <span>Escuchar</span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<hr>
