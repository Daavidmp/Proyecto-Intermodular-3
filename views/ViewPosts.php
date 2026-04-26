<?php 
    require_once "../controllers/post.php";
    $postIds      = array_column($posts, 'id');
    $votosUsuario = obtenerVotosUsuarioEnPosts($conexion, $_SESSION['id'], $postIds);
?>
<div class="posts">
    <h1>Inicio</h1>
    <hr>
    <div class="contenido__posts">
        <?php foreach($posts as $p): ?>
            <?php $voto = $votosUsuario[$p['id']] ?? null; ?>
            <div class="post__container">
                <div class="post__columna__izquierda">
                    <div class="post__avatar">
                        <img src="<?php echo $p["avatar_url"]; ?>">
                        <p><?php echo $p["username"] ?></p>
                    </div>
                    <div class="contenido__texto">
                        <p><?php echo $p["contenido"] ?></p>
                    </div>
                    <button class="mostrar__mas__btn" onclick="toggleTexto(this)">
                        Mostrar más
                    </button>
                </div>

                <div class="post__valoraciones">
                    <button class="post__valoraciones__likes <?php echo $voto === 'like' ? 'activo' : ''; ?>" data-id-post="<?php echo $p['id'] ?>">
                        <img src="https://cdn-icons-png.flaticon.com/128/9513/9513802.png">
                        <p><?php echo $p["likes"] ?? 0 ?></p>
                    </button>
                    <button class="post__valoraciones__dislikes <?php echo $voto === 'dislike' ? 'activo' : ''; ?>" data-id-post="<?php echo $p['id'] ?>">
                        <img src="https://cdn-icons-png.flaticon.com/128/880/880613.png">
                        <p><?php echo $p["dislikes"] ?? 0 ?></p>
                    </button>
                </div>

                <div class="post__columna__derecha">
                    <a href="<?php echo $p["music_link"] ?>" class="post__music__link" target="_blank">
                        <img class="post__music__image" src="<?php echo $p["image_link"] ?>" alt="Portada de música">
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