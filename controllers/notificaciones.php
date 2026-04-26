<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../models/conexionDatabase.php';
require_once __DIR__ . '/../models/TablaMisiones.php';

header('Content-Type: application/json');

$conexion = conexion();
$usuario_id = $_SESSION['id'] ?? null;

if (!$usuario_id) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'No autenticado']);
    exit;
}

$accion = $_GET['accion'] ?? $_POST['accion'] ?? '';

switch ($accion) {

    case 'obtener':
        $notifs = obtenerNotificaciones($conexion, $usuario_id);
        $sin_leer = contarNotificacionesSinLeer($conexion, $usuario_id);
        echo json_encode(['success' => true, 'notificaciones' => $notifs, 'sin_leer' => $sin_leer]);
        break;

    case 'contar':
        $sin_leer = contarNotificacionesSinLeer($conexion, $usuario_id);
        echo json_encode(['success' => true, 'sin_leer' => $sin_leer]);
        break;

    case 'marcar_leidas':
        marcarNotificacionesLeidas($conexion, $usuario_id);
        echo json_encode(['success' => true]);
        break;

    case 'recoger_recompensa':
        $logro_id = $_POST['logro_id'] ?? null;
        if (!$logro_id) {
            echo json_encode(['success' => false, 'error' => 'Falta logro_id']);
            break;
        }
        $resultado = recogerRecompensa($conexion, $usuario_id, $logro_id);
        echo json_encode($resultado);
        break;

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Acción desconocida']);
}
?>
