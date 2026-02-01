<?php 
    session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaSeguidores.php";
    
    $conexion = conexion();

    $resultado = listarUsuarios($conexion);
    $id = obtenerIdPorUsername($conexion, $_SESSION["username"]);
    $chat = listarUsuariosALosQueSigo($conexion, $id);
?>