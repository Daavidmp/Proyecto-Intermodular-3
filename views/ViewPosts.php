<?php 
    include "../controllers/post.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../posts.css'>
    <script src='../scripts/sidebar.js'></script>
</head>
<body>
    <div class="sidebar">
        <h1 class="titulo">MRTN</h1>
        <button class="sidebar__inicio" onclick="window.location.href='ViewPosts.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/25/25694.png">
            <p>Inicio</p>
        </button>
        <button class="sidebar__buscar" id="btn__explorar" onclick="window.location.href='formExplorar.php'">
            <img src="https://cdn-icons-png.flaticon.com/512/2319/2319177.png">
                <p>Explorar</p>
        </button>
        <button class="sidebar__notificaciones">
            <img src="https://cdn-icons-png.flaticon.com/128/4991/4991422.png">
            <p>Notificaciones</p>
        </button>
        <button class="sidebar__mensajes" onclick="window.location.href='ViewMensajes.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/520/520648.png">
            <p>Mensajes</p>
        </button>
        <button class="sidebar__perfil" id="btn__perfil" onclick="window.location.href='formMenu.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/9308/9308015.png">
            <p>Perfil</p>
        </button>
        <button class="sidebar__musica">
            <img src="https://cdn-icons-png.flaticon.com/128/651/651717.png">
            <p>Mi musica</p>
        </button>
        <button class="sidebar__vivo">
            <img src="https://cdn-icons-png.flaticon.com/128/8459/8459506.png">
            <p>En vivo</p>
        </button>
        <button class="cerrar__sesion" onclick="window.location.href = '../controllers/cerrarSesion.php'">
            <img src="https://cdn-icons-png.flaticon.com/512/660/660350.png">
            <p>Cerrar Sesión</p>
        </button>
    </div>
    <div class="posts">
        <h1>Inicio</h1>
        <hr>
        <div class="contenido__posts">
            <?php foreach($posts as $p): ?>
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
</body>
<script src="../scripts/mostrarMas.js"></script>
</html>