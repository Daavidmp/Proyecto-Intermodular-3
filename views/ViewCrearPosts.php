<?php 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicar Posts</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../posts.css'>
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
        <button class="sidebar__monedas" onclick="window.location.href='ViewComprarMonedas.php'">
                <img src="https://cdn-icons-png.flaticon.com/512/846/846061.png">
                <p>Comprar Monedas</p>
            </button>
        <button class="cerrar__sesion" onclick="window.location.href = '../controllers/cerrarSesion.php'">
            <img src="https://cdn-icons-png.flaticon.com/512/660/660350.png">
            <p>Cerrar Sesión</p>
        </button>
    </div>
    <div class="form-container">
        <form action="../controllers/post.php" method="post">
            <h1 class="form__titulo">Crear Nuevo Post</h1>
            
            <label for="contenido" class="form__label">Contenido del post</label>
            <textarea name="contenido" id="contenido" class="form__input" placeholder="Escribe el contenido de tu post..."></textarea>

            <label for="image_link" class="form__label">Imagen</label>
            <input type="text" name="image_link" class="form__input">

            <label for="music_link" class="form__label">Link a la canción</label>
            <input type="text" name="music_link" id="music_link" class="form__input" placeholder="Pega el enlace de la canción...">
            
            <button id="btn_posts">Crear Post</button>
        </form>
    </div>
</body>
</html>