<?php 
    if (session_status() === PHP_SESSION_NONE) 
    {
        session_start();
    }

    require_once "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaGacha.php";

    $conexion = conexion();

    $usuario = $_SESSION["username"];
    $usuario_id = obtenerIdPorUsername($conexion, $usuario);

    $saldoTotal = mostrarSaldo($conexion, $usuario_id);

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if(isset($_POST["accion"]) && $_POST["accion"] == "banner")
        {
            if(isset($_POST["nombre_imagen"]))
            {
                actualizarBanner($conexion, $usuario_id, $_POST["nombre_imagen"]);
                echo "Banner actualizado";
                exit;
            }
        }
    }

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if(isset($_POST["accion"]) && $_POST["accion"] == "tirarGacha")
        {
            if($saldoTotal >= 10)
            {
                descontarMonedas($conexion, $saldoTotal, $usuario_id);
                $datos_gacha = obtenerImagenGachaConRareza();

                $nombre_imagen = $datos_gacha["nombre"];
                $rareza = $datos_gacha["rareza"];

                guardarRecompensa($conexion, $nombre_imagen, $rareza, $usuario_id);

                echo json_encode([
                    "success" => true,
                    "message" => "¡Gacha completado! Obtuviste: $nombre_imagen (Rareza: $rareza)"
                ]);

                exit;
            }
            else
            {
                echo json_encode([
                    "success" => false,
                    "message" => "Saldo insuficiente. Necesitas 10 monedas. (Tienes: $saldoTotal)"
                ]);
                exit;
            }
        }
    }

    $itemsUsuario = mostrarItems($conexion, $usuario_id);
    $miBanner = obtenerBannerDeMiUsuario($conexion, $usuario_id);
?>