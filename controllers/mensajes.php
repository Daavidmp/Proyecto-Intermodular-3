<?php 
    session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaMensajes.php";
    
    $conexion = conexion();

    $resultado = listarUsuarios($conexion);
?>