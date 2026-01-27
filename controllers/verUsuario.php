<?php 
    session_start();

    if(!isset($_SESSION["username"])) 
    {
        header("Location: login.php");
        exit;
    }

    // Obtener el usuario desde la URL
    $usuario_perfil = isset($_GET['username']) ? $_GET['username'] : '';
    
    if(empty($usuario_perfil)) 
    {
        header("Location: ../formExplorar.php");
        exit;
    }

    $usuario_sesion = $_SESSION["username"];
    
    include "../models/TablaUsuario.php";
    include "../models/TablaPosts.php";
    include "../models/TablaSeguidores.php";
    require_once "../controllers/post.php";
    
    $conexion = conexion();
    
    $datosUsuario = obtenerDatosUsuario($conexion, $usuario_perfil);
    
    if(!$datosUsuario) 
    {
        header("Location: ../formExplorar.php");
        exit;
    }
    
    $username = $datosUsuario['username'];
    $biografia = $datosUsuario['biografia'] ?? '';
    $avatar_url = $datosUsuario['avatar_url'] ?? '../img/iconodefault.jpg';
    $ubicacion = $datosUsuario['ubicacion'] ?? '';
    $fecha = $datosUsuario['fecha'] ?? date('Y-m-d');
    $enlace_spoty = $datosUsuario['enlace_spoty'] ?? '#';
    $usuario_id = $datosUsuario['id'];
    
    $posts_totales = obtenerPostsTotalesUsuario($conexion, $username);
    $siguiendo = obtenerSiguiendoUsuario($conexion, $usuario_id);
    $seguidores = obtenerSeguidoresUsuario($conexion, $usuario_id);
?>