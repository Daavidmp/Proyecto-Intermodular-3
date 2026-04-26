<?php
    ob_start();
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: /views/formLogin.php");
        exit;
    }
    // Cargar cursor activo del usuario para aplicarlo globalmente
    require_once __DIR__ . '/../models/conexionDatabase.php';
    require_once __DIR__ . '/../models/TablaGacha.php';
    $conexion_app  = conexion();
    $uid_app       = $_SESSION['id'] ?? null;
    $cursor_activo = $uid_app ? obtenerCursorActivo($conexion_app, $uid_app) : null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MRTN</title>

    <link rel="stylesheet" href="/css/chat.css">
    <link rel="stylesheet" href="/css/comprar.css">
    <link rel="stylesheet" href="/css/editarPerfil.css">
    <link rel="stylesheet" href="/css/explorar.css">
    <link rel="stylesheet" href="/css/gacha.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/logros.css">
    <link rel="stylesheet" href="/css/notificaciones.css">
    <link rel="stylesheet" href="/css/mensajes.css">
    <link rel="stylesheet" href="/css/menu.css">
    <link rel="stylesheet" href="/css/posts.css">
    <link rel="stylesheet" href="/css/register.css">
    <link rel="stylesheet" href="/css/sidebar.css">

    <?php if ($cursor_activo): ?>
    <style>
        /* Cursor personalizado del usuario */
        *, *::before, *::after {
            cursor: url('/img/cursores/<?php echo htmlspecialchars($cursor_activo); ?>') 0 0, auto !important;
        }
    </style>
    <?php endif; ?>
</head>
<body style="margin:0; padding:0; overflow-x:hidden;"
      <?php if ($cursor_activo): ?>data-cursor="<?php echo htmlspecialchars($cursor_activo); ?>"<?php endif; ?>>
    <?php include 'sidebar.php'; ?>

    <div class="main__content">
        <?php include 'formMenu.php'; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/scripts/app.js"></script>
    <script src="/scripts/sidebar.js"></script>

    <script>
    // Actualizar cursor dinámicamente sin recargar página
    window.aplicarCursorActivo = function(nombreCursor) {
        var existing = document.getElementById('cursor__style__dinamico');
        if (existing) existing.remove();
        if (nombreCursor) {
            var s = document.createElement('style');
            s.id = 'cursor__style__dinamico';
            s.textContent = '*, *::before, *::after { cursor: url("/img/cursores/' + nombreCursor + '") 0 0, auto !important; }';
            document.head.appendChild(s);
            document.body.dataset.cursor = nombreCursor;
        } else {
            document.body.removeAttribute('data-cursor');
        }
    };

    const flecha = document.querySelector(".main__content__section1__flecha");

    flecha.addEventListener("click", () => {
        window.history.back();
    })
    </script>
</body>
</html>