<?php 
    include "../controllers/gacha.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../gacha.css'>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Items</title>
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
    <div class="gacha">
        <h1>Mi Colección</h1>
        
        <?php 
        $totalItems = count($itemsUsuario ?? []);
        if($totalItems > 0): 
        ?>
            <div class="items-count">
                <?php echo $totalItems; ?> items en tu colección
            </div>
            
            <div class="gacha-container">
                <?php foreach($itemsUsuario as $i): 
                    $rareza = htmlspecialchars($i['rareza'] ?? 'comun');
                    $nombre = htmlspecialchars($i['nombre_imagen'] ?? '');
                    $nombreSinExtension = pathinfo($nombre, PATHINFO_FILENAME);
                    $nombreFormateado = ucwords(str_replace('_', ' ', $nombreSinExtension));
                ?>
                <div class="gacha_imagen">
                    <div class="image-wrapper">
                        <span class="rarity-badge <?php echo $rareza; ?>">
                            <?php echo $rareza; ?>
                        </span>
                        <img src="../img/coleccionables/<?php echo $rareza; ?>/<?php echo $nombre; ?>"
                            alt="<?php echo $nombreFormateado; ?>"
                            onerror="this.src='../img/default_banner.jpg'">
                    </div>
                    
                    <div class="item-info">
                        <span class="item-name" title="<?php echo $nombreFormateado; ?>">
                            <?php echo $nombreFormateado; ?>
                        </span>
                        
                        <button class="añadir__banner" data-banner="<?php echo $nombre?>">Añadir Banner</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-items-container">
                <div class="icon">📭</div>
                <h2>Colección vacía</h2>
                <p>Aún no has obtenido ningún banner del gacha.</p>
                <p>¡Juega para conseguir recompensas exclusivas!</p>
            </div>
        <?php endif; ?>
        
        <button class="btn__tirar__gacha" id="tirarGacha">Tirar Gacha</button>
    </div>
</body>
<script>
    $(document).ready(function() {
        $(document).on('click', '.añadir__banner', function() {
            var nombre_imagen = $(this).data('banner')
            $.ajax({
                url: "../controllers/gacha.php",
                type: "POST",
                data: {
                    accion: "banner",
                    nombre_imagen : nombre_imagen
                },

                success: function(response)
                {
                    window.location.href="formMenu.php";
                }
            });
        });

        $("#tirarGacha").click(function (){
            $.ajax({
                url: "../controllers/gacha.php",
                type: "POST",
                data: {
                    accion: "tirarGacha",
                },

                success: function(response)
                {
                    alert("Has obtenido un nuevo Banner")
                    location.reload();
                }
            });
        });
    });
</script>
</html>