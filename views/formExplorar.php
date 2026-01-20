<?php 
    include "../controllers/buscar.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar</title>
    <script src="../scripts/sidebar.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../explorar.css'>
    <style>
        /* Añade esto para asegurar que los usuarios sean visibles */
        .usuario-item {
            display: flex !important;
        }
        
        .no-resultados {
            color: #8b8b8b;
            font-size: 18px;
            text-align: center;
            padding: 40px;
            width: 100%;
        }
    </style>
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
    <div class="explorar">
        <h1>Buscar Personas</h1>
        <p>Descubre usuarios que tengan los mismos gustos musicales que tu</p>
        <input type="text" id="buscador" name="buscar" placeholder="Buscar por nombre de usuario">
        
        <!-- LOS USUARIOS DEBEN ESTAR DENTRO DE .explorar -->
        <div class="explorar__usuarios" id="lista-usuarios">
            <?php 
                if(empty($resultado)) 
                {
                    echo "<p class='no-resultados'>No hay usuarios para mostrar</p>";
                } 
                else 
                {
                    foreach($resultado as $usuario) 
                    {
                        echo "<div class='usuario-item'>";
                        echo "<button class='explorar__usuarios__boton' onclick=\"verUsuario('" . $usuario['username'] . "')\">";
                        echo "<img src='" . (!empty($usuario['avatar_url']) ? $usuario['avatar_url'] : '../img/iconodefault.jpg') . "' 
                        alt='" . $usuario['username'] . "'onerror=\"this.src='../img/iconodefault.jpg'\">";
                        echo "</button>"; 
                        echo "<div class='explorar__usuarios__info'><p class='nombre-usuario'>" . $usuario["username"] . "</p>
                            <p>@" . $usuario["username"] . "</p>
                        </div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>
    
    <script src="../scripts/usuario.js"></script>
</body>
</html>