<?php 
    include_once "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";

    $conexion = conexion();

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $contenido = $_POST["contenido"] ?? "";
        $music_link = $_POST["music_link"] ?? "";
        $usuario_id = obtenerIdPorUsername($conexion, $_SESSION["username"]);

        crearPost($conexion, $usuario_id, $contenido, $music_link);

        header("Location: ../views/formMenu.php");
        exit;
    }    

    $postDeUsuario = mostrarPostsDeUnUsuario($conexion, $_SESSION["username"]);
?>