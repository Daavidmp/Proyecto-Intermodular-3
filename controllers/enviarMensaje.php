<?php
session_start();
include "../models/conexionDatabase.php";
require_once "../models/TablaMensajes.php";

$conexion = conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $receptor_id = $_POST['receptor_id'];
    $contenido = $_POST['contenido'];
    $usuario_actual = $_SESSION["username"];
    
    // Obtener ID del emisor
    $emisor_id = obtenerIdPorUsername($conexion, $usuario_actual);
    
    // Enviar mensaje
    if (enviarMensaje($conexion, $emisor_id, $receptor_id, $contenido)) {
        // Redirigir de vuelta al chat
        header("Location: ../views/ViewChat.php?receptor_id=" . $receptor_id);
        exit;
    } else {
        echo "Error al enviar el mensaje";
    }
}
?>