<?php
if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

require_once "../models/conexionDatabase.php";
require_once "../models/TablaPosts.php";
require_once "../models/TablaMisiones.php";

$conexion   = conexion();
$usuario_id = $_SESSION["id"] ?? null;

if (!$usuario_id) { echo json_encode(["error" => "No autenticado"]); exit; }
if ($_SERVER["REQUEST_METHOD"] !== "POST") { echo json_encode(["error" => "Método no permitido"]); exit; }

$post_id = $_POST["post_id"] ?? null;
$accion  = $_POST["accion"]  ?? null;

if (!$post_id || !in_array($accion, ["like", "dislike"])) {
    echo json_encode(["error" => "Datos inválidos"]); exit;
}

$votoActual = obtenerVotoUsuario($conexion, $usuario_id, $post_id);

if ($votoActual === $accion) {
    // Toggle off: quitar voto
    eliminarVoto($conexion, $usuario_id, $post_id);
    $accion === "like" ? cambiarContadorLikes($conexion, $post_id, -1) : cambiarContadorDislikes($conexion, $post_id, -1);
    $nuevoVoto = null;

} elseif ($votoActual !== null) {
    // Cambiar voto contrario
    actualizarVoto($conexion, $usuario_id, $post_id, $accion);
    if ($accion === "like") {
        cambiarContadorLikes($conexion, $post_id, +1);
        cambiarContadorDislikes($conexion, $post_id, -1);
    } else {
        cambiarContadorDislikes($conexion, $post_id, +1);
        cambiarContadorLikes($conexion, $post_id, -1);
    }
    $nuevoVoto = $accion;

} else {
    // Voto nuevo
    insertarVoto($conexion, $usuario_id, $post_id, $accion);
    $accion === "like" ? cambiarContadorLikes($conexion, $post_id, +1) : cambiarContadorDislikes($conexion, $post_id, +1);
    $nuevoVoto = $accion;
}

$totales = obtenerTotalesPost($conexion, $post_id);
if ($nuevoVoto === "like") checkMisionLike($conexion, $usuario_id);
if ($nuevoVoto === "dislike") checkMisionDislike($conexion, $usuario_id);
echo json_encode([
    "success"  => true,
    "likes"    => (int)$totales["likes"],
    "dislikes" => (int)$totales["dislikes"],
    "voto"     => $nuevoVoto
]);