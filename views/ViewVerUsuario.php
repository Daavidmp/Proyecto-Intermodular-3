<?php 
    require_once "../controllers/verUsuario.php";
    $postIdsVer   = array_column($postDeOtroUsuario, 'id');
    $votosUsuario = obtenerVotosUsuarioEnPosts($conexion, $_SESSION['id'], $postIdsVer);
    $ya_le_sigo = esSeguidor($conexion, $_SESSION["id"], $usuario_id);
?>
    <div class="main__content__section1">
        <img class="main__content__section1__flecha" src="../img/flecha.png" style="cursor: pointer;">
        <div class="profile-header-info">
            <h1 class="profile-name"><?php echo $username; ?></h1>
            <span class="post-count"><?php echo $posts_totales . " posts"; ?></span>
        </div>
    </div>
    <div class="containers">
        <div class="banner">
            <?php if(!empty($bannerOtroUsuario["banner"]) && !empty($bannerOtroUsuario["rareza"])): ?>
                <img src="../img/coleccionables/<?php echo htmlspecialchars($bannerOtroUsuario["rareza"]); ?>/<?php echo htmlspecialchars($bannerOtroUsuario["banner"]); ?>"
                    onerror="this.src='../img/banner-default.jpg'">
            <?php else: ?>
                <img src="../img/bannerejemplo.jpg" alt="Banner por defecto">
            <?php endif; ?>
        </div>
        <div class="img__perfil">
            <img src="<?php echo $avatar_url; ?>"
                onerror="this.src='../img/iconodefault.jpg'">
        </div>
    </div>
    <div class="main__content__section2">
        <button class="btn-compartir">
            <img src="https://cdn-icons-png.flaticon.com/128/3832/3832624.png">
        </button>
        <button class="btn-trespuntos">
            <img src="https://cdn-icons-png.flaticon.com/128/512/512142.png">
        </button>
        <?php if($usuario_sesion === $username): ?>
        <button class="btn-config" onclick="loadSection('../FormEditarPerfil.php')">
            <img src="https://cdn-icons-png.flaticon.com/128/1242/1242494.png">
            <p class="btn-texto">Editar perfil</p>
        </button>
        <?php else: ?>
        <button class="btn-config" id="btn-seguir" data-username="<?php echo $username?>" <?php echo $ya_le_sigo ? 'disabled style="opacity:0.7"' : ''; ?>>
            <img src="https://cdn-icons-png.flaticon.com/128/1828/1828817.png">
            <p class="btn-texto"><?php echo $ya_le_sigo ? "Siguiendo ✓" : "Seguir"; ?></p>
        </button>
        <?php endif; ?>
    </div>
    <hr>
    <div class="main__content__section3">
        <div class="nombre__tag">
            <p class="nombre__tag__usuario"><?php echo $username; ?></p>
            <p class="nombre__tag__tag">@<?php echo $username; ?></p>
        </div>
    </div>
    <hr>
    <div class="main__content__section4">
        <p><?php echo $biografia; ?></p>
    </div>
    <hr>
    <div class="main__content__section5">
        <p class="main__content__section5__ubi"><?php echo $ubicacion; ?></p>
        <a href="<?php echo $enlace_spoty; ?>"
            class="main__content__section5__spoty" target="_blank">
            <?php echo $username . ".com"; ?>
        </a>
        <p class="main__content__section5__fecha">
            <?php
                $dt = new DateTime($fecha);
                echo "Se unió: " . $dt->format('m/Y');
            ?>
        </p>
    </div>
    <div class="main__content__section6">
        <p class="main__content__section6__espacio">
            <img src="https://cdn-icons-png.flaticon.com/128/651/651717.png">
            <?php echo "<b>" . $posts_totales . "</b>" . " Posts"; ?>
        </p>
        <p>
            <?php echo "<b>" . $siguiendo . "</b>" . " Siguiendo"; ?>
        </p>
        <p>
            <?php echo "<b>" . $seguidores . "</b>" . " Seguidores"; ?>
        </p>
    </div>
    <hr>
    <div class="main__content__section7">
        <h1>Posts</h1>
        <div class="contenido__posts">
            <?php foreach($postDeOtroUsuario as $posts): ?>
                <div class="post__container">
                    <div class="post__columna__izquierda">
                        <div class="post__avatar">
                            <img src="<?php echo $avatar_url; ?>">
                            <p><?php echo $username?></p>
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