<?php 
    if (session_status() === PHP_SESSION_NONE) 
    {
        session_start();
    }

    include_once "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaPosts.php";

    $conexion = conexion();

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $contenido = $_POST["contenido"] ?? "";
        $image_link = $_POST["image_link"] ?? "";
        $music_link = $_POST["music_link"] ?? "";
        $usuario_id = obtenerIdPorUsername($conexion, $_SESSION["username"]);

        crearPost($conexion, $usuario_id, $contenido, $image_link, $music_link);

        header("Location: ../views/formMenu.php");
        exit;
    }

    // Esto es para mi usuario
    $postDeMiUsuario = mostrarPostsDeUnUsuario($conexion, $_SESSION["username"]);

    // Esto es para el usuario que quiera ver
    $postDeOtroUsuario = [];
    if (isset($_GET["username"])) 
    {
        $postDeOtroUsuario = mostrarPostsDeUnUsuario($conexion, $_GET["username"]);
    }

    // 4. Obtener todos los posts (Para el menu)
    $posts = mostrarPosts($conexion);
?>