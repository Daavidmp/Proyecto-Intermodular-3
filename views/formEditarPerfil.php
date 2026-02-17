<?php 
    session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: formLogin.php");
        exit;
    }
    
    include "../models/conexionDatabase.php";
    $conexion = conexion();
    
    $sql = "SELECT username, avatar_url, biografia, email, ubicacion, enlace_spoty FROM usuarios WHERE username = :username";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':username', $_SESSION["username"]);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/editarPerfil.css'>
    <script src="../scripts/sidebar.js"></script>
</head>
<body>
    <div class="editar__perfil">
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
    
        <div class="form">
            <form action="../controllers/editar.php" method="post">
                <h1 class="form__titulo">Editar Perfil</h1>
                <label for="username" class="form__label">Usuario</label>
                <input type="text" name="username" class="form__input" value="<?php echo $usuario['username']; ?>">

                <label for="avatar_url" class="form__label">Foto de Perfil</label>
                <input type="text" name="avatar_url" class="form__input" value="<?php echo $usuario['avatar_url']; ?>">

                <label for="biografia" class="form__label">Biografia</label>
                <input type="text" name="biografia" class="form__input" value="<?php echo $usuario['biografia']; ?>">

                <label for="contrasenya" class="form__label">Contraseña (dejala en blanco para no cambiarla)</label>
                <input type="password" name="contrasenya" class="form__input">

                <label for="email" class="form__label">Correo Electronico</label>
                <input type="email" name="email" class="form__input" value="<?php echo $usuario['email']; ?>">

                <label for="ubicacion" class="form__label">Ubicación</label>
                <input type="text" name="ubicacion" class="form__input" value="<?php echo $usuario['ubicacion']; ?>">

                <label for="enlace_spoty" class="form__label">Enlace Spotify</label>
                <input type="text" name="enlace_spoty" class="form__input" value="<?php echo $usuario['enlace_spoty']; ?>">

                <button type="submit" id="btn__form__editar">Guardar Cambios</button>
            </form>
        </div>
    </div>
</body>
</html>