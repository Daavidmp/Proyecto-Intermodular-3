<?php 
    session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaMisiones.php";
    
    $conexion = conexion();

    $misiones = mostrarMisiones($conexion);
?>