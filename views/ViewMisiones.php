<?php 
    require_once "../controllers/logros.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misiones</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/logros.css'>
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
        <button class="sidebar__logros" onclick="window.location.href='ViewMisiones.php'">
            <img src="https://cdn-icons-png.flaticon.com/128/8527/8527971.png">
            <p>Mis misiones</p>
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
    <div class="logros">
        <h1>Mis misiones</h1>
        <div class="logros__misiones">
            <?php foreach($misiones as $m):?>
                <div class="logros__misiones__mision">
                    <img src="<?php echo $m["icono"]?>">
                    <p><?php echo $m["nombre"]?></p>
                    <a><?php echo $m["descripcion"]?></a>
                </div>
                <button>Completado</button>
            <?php endforeach;?>
        </div>
    </div>
</body>
</html>