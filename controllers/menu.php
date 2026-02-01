<?php 
    include "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaPosts.php";

    $conexion = conexion();

    $resultado = obtenerDatos($conexion);
    $postsTotales = obtenerPostsTotalesUsuario($conexion, $_SESSION["username"]);

    if($resultado) 
    {
        $biografia = $resultado['biografia'];
        $avatar_url = $resultado['avatar_url'];
        $ubicacion = $resultado['ubicacion'];
        $fecha = $resultado['fecha'];
        $enlace_spoty = $resultado['enlace_spoty'];
        
        if(empty($biografia)) 
        {
            $biografia = "¡Hola Usuario! | Esta es mi biografía en MRTN";
        }

        if(empty($avatar_url)) 
        {
            $avatar_url = "../img/iconodefault.jpg";
        }

        if(empty($ubicacion))
        {
            $ubicacion = "Madrid/España";
        }

        $_SESSION['avatar_url'] = $avatar_url;
    } 
    else 
    {
        $biografia = "Usuario no encontrado";
    }
?>