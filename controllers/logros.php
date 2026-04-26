<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaMisiones.php";
    
    $conexion = conexion();

    $usuario_id = $_SESSION["id"] ?? null;
    $misiones   = $usuario_id
        ? mostrarMisionesConEstado($conexion, $usuario_id)
        : mostrarMisiones($conexion);
?>
