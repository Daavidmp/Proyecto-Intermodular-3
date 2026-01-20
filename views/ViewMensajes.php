<?php 
    session_start();
    
    include "../models/conexionDatabase.php";
    include "../controllers/buscar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../mensajes.css'>
</head>
<body>
    <div class="sidebar">
        <h1 class="titulo">MRTN</h1>
        <button class="sidebar__inicio">
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
    <div class="mensajes">
        <input type="text" id="buscador" name="buscar" placeholder="Buscar por nombre de usuario">
        <p>Mensajes</p>
        <?php  
            foreach($resultado as $usuarios)
            {
                echo "Prueba";
            }  
        ?>
    </div>
</body>
</html>