<?php 
    include "../controllers/mensajes.php";
    date_default_timezone_set('Europe/Madrid');
    
    $usuario_actual = $_SESSION["username"];
    
    // A continuacion obtengo los ids del usuario en sesion y con el que quiero hablar
    $emisor_id = obtenerIdPorUsername($conexion, $usuario_actual);
    $receptor_id = $_GET['receptor_id']; // ID del usuario con el que se chatea
    
    // Obtener mensajes
    $mensajes = mostrarMensajesEntreUsuarios($conexion, $emisor_id, $receptor_id);
    
    // Obtener información del receptor
    $receptor_info = obtenerUsuarioPorId($conexion, $receptor_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat con <?php echo $receptor_info['username']; ?></title>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/chat.css'>
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
        <button class="sidebar__logros">
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
    
    <div class="chat-container">
        <div class="chat-header">
            <img src="<?php echo $receptor_info['avatar_url']; ?>" class="avatar">
            <h2><?php echo $receptor_info['username']; ?></h2>
        </div>
        
        <div class="chat-messages">
            <?php foreach($mensajes as $mensaje): ?>
                <div class="message <?php echo $mensaje['emisor_id'] == $emisor_id ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($mensaje['contenido']); ?></p>
                    <span class="time"><?php echo date('H:i', strtotime($mensaje['fecha_envio'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
        
        <form method="POST" action="../controllers/enviarMensaje.php" class="chat-input">
            <input type="hidden" name="receptor_id" value="<?php echo $receptor_id; ?>">
            <input type="text" name="contenido" placeholder="Escribe un mensaje..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>