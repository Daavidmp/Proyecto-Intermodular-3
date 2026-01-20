<?php 
    session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    
    $conexion = conexion();

    $resultado = listarUsuarios($conexion);
?>