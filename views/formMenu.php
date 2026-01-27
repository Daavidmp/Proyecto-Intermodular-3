<?php 
    session_start();

    if(!isset($_SESSION["username"])) 
    {
        header("Location: login.php");
        exit;
    }

    require_once "../controllers/menu.php";
    require_once "../models/TablaPosts.php";
    require_once "../models/TablaSeguidores.php";

    $usuario = $_SESSION["username"];
    $conexion = conexion();
    $postDeMiUsuario = mostrarPostsDeUnUsuario($conexion, $usuario);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../menu.css'>
    <script src='../scripts/sidebar.js'></script>
</head>
<body>
    <div class="profile">
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

        <div class="main__content">
            <div class="main__content__section1">
                <img class="main__content__section1__flecha" src="../img/flecha.png">
                <div class="profile-header-info">
                    <h1 class="profile-name"><?php echo $usuario; ?></h1>
                    <span class="post-count"><?php echo $postsTotales . " posts"?></span>
                </div>
            </div>
            <div class="containers">
                <div class="banner">
                    <img src="../img/bannerejemplo.jpg">
                </div>
                <div class="img__perfil">
                    <img src="<?php echo $avatar_url?>" onerror="this.src='../img/iconodefault.jpg'">
                </div>
            </div>
            <div class="main__content__section2">
                <button class="btn-compartir">
                    <img src="https://cdn-icons-png.flaticon.com/128/3832/3832624.png">
                </button>
                <button class="btn-trespuntos">
                    <img src="https://cdn-icons-png.flaticon.com/128/512/512142.png">
                </button>
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
                <p><?php echo "<b>" . obtenerSiguiendo($conexion) . "</b>" . " Siguiendo"?></p>
                <p><?php echo "<b>" . obtenerSeguidores($conexion) . "</b>" ." Seguidores"?></p>
                <button onclick="window.location.href='ViewCrearPosts.php'">Añadir Post</button>
            </div>
            <div class="main__content__section7">
                <h1>Posts</h1>
                <?php foreach($postDeMiUsuario as $posts):?>
                <div class="main__content__section7__post">
                    <div class="main__content__section7__post__primer">
                        <img src="<?php echo $_SESSION["avatar_url"];?>">
                        <p><?php echo $_SESSION["username"]?></p>
                    </div>
                    <div class="main__content__section7__post__segon">
                        <p><?php echo $posts["contenido"]?></p>
                        <a href="<?php echo $posts["music_link"]?>">
                            <img class="foto" src="<?php echo $posts["image_link"]?>">
                        </a>
                    </div>
                </div>
                <?php endforeach;?>    
            </div>
            <hr>
        </div>
    </div>
</body>
</html>