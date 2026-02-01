<?php 
    session_start();

    if(!isset($_SESSION["username"])) 
    {
        header("Location: login.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if(isset($_POST["accion"]) && $_POST["accion"] == "seguir")
        {
            if(isset($_POST["username_a_seguir"]))
            {
                require_once "../models/TablaSeguidores.php";
                require_once "../models/TablaUsuario.php";
                include "../models/conexionDatabase.php";
                
                $conexion = conexion();

                $receptor_id = obtenerIdPorUsername($conexion, $_POST["username_a_seguir"]);

                if($receptor_id && isset($_SESSION["id"])) 
                {
                    $resultado = seguirUsuario($conexion, $receptor_id, $_SESSION["id"]);
                }
            }

            if($resultado)
            {
                echo "Usuario seguido correctamente";
            }
            else 
            {
                echo "Error al seguir usuario";
            }
            
            exit;
        }
    }

    include "../models/TablaUsuario.php";
    include "../models/TablaPosts.php";
    include "../models/TablaSeguidores.php";
    require_once "../controllers/post.php";
    
    // Obtener el usuario desde la URL
    $usuario_perfil = isset($_GET['username']) ? $_GET['username'] : '';
    
    if(empty($usuario_perfil)) 
    {
        header("Location: ../formExplorar.php");
        exit;
    }

    $usuario_sesion = $_SESSION["username"];
    
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
    
    $bannerOtroUsuario = obtenerBannerDeMiUsuario($conexion, $datosUsuario["id"]);
?>