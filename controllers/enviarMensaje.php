<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . "/../models/conexionDatabase.php";
require_once __DIR__ . "/../models/TablaMensajes.php";
require_once __DIR__ . "/../models/TablaMisiones.php";

header('Content-Type: application/json');

$conexion = conexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $receptor_id    = $_POST['receptor_id'] ?? null;
    $contenido      = $_POST['contenido']   ?? null;
    $emisor_id      = $_SESSION["id"]       ?? null;

    if (!$receptor_id || !$contenido || !$emisor_id) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Datos incompletos o sesión caducada']);
        exit;
    }

    if (enviarMensaje($conexion, $emisor_id, $receptor_id, $contenido)) {
        // Crear notificación para el receptor
        $emisor_username = $_SESSION["username"] ?? "Alguien";
        crearNotificacionMensaje($conexion, $receptor_id, $emisor_username, $emisor_id);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Error al guardar el mensaje']);
    }
}
?>
