<?php 
    include "../controllers/gacha.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprar MRTNs</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../sidebar.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../comprar.css'>
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
    </div>
    <div class="comprar">
        <h1>Comprar Monedas</h1>
        <span><?php echo "Monedas totales: " . $saldoTotal . " MRTNs"?></span>
        <div class="comprar__monedas">
            <div class="comprar__monedas__4.99">
                <img src="../img/MRTNs/4.99.png" alt="50 MRTNs">
                <div class="paquete-info">
                    <div class="cantidad-monedas">50 MRTNs</div>
                    <div class="precio-etiqueta">4.99€</div>
                </div>
                <button>Comprar</button>
            </div>
            <div class="comprar__monedas__9.95">
                <img src="../img/MRTNs/9.95.png" alt="110 MRTNs">
                <div class="paquete-info">
                    <div class="cantidad-monedas">110 MRTNs</div>
                    <div class="precio-etiqueta">9.95€</div>
                </div>
                <button>Comprar</button>
            </div>
            <div class="comprar__monedas__24.99">
                <img src="../img/MRTNs/24.99.png" alt="BONUS">
                <div class="paquete-info">
                    <div class="cantidad-monedas">BONUS!</div>
                    <div class="precio-etiqueta">24.99€</div>
                </div>
                <button>Comprar</button>
            </div>
            <div class="comprar__monedas__49.99">
                <img src="../img/MRTNs/49.99.png" alt="Paquete Premium">
                <div class="paquete-info">
                    <div class="cantidad-monedas">250 MRTNs</div>
                    <div class="precio-etiqueta">49.99€</div>
                </div>
                <button>Comprar</button>
            </div>
        </div>
        <p>De conformidad con nuestras políticas, la plataforma MRTN no procesa reembolsos ni acepta devoluciones por compras realizadas. Cada usuario asume la plena responsabilidad por las adquisiciones que efectúa en la red.</p>
    </div>
</body>
</html>