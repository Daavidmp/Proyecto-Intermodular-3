<?php 
    session_start();
    header('Content-Type: application/json');

    require_once "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    require_once "../models/TablaMisiones.php";
    $conexion = conexion();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["success" => false, "message" => "Método no permitido."]);
        exit;
    }

    $username    = trim($_POST["username"] ?? "");
    $contrasenya = $_POST["password"] ?? "";

    if ($username === "" || $contrasenya === "") {
        echo json_encode(["success" => false, "message" => "Rellena todos los campos."]);
        exit;
    }

    $usuarios = obtenerUsuarioContrasenya($conexion);

    // FIX #2: password_verify en vez de comparación en texto plano
    foreach ($usuarios as $u) {
        if ($username === $u["username"] && password_verify($contrasenya, $u["contrasenya"])) {
            $_SESSION["username"] = $username;
            $uid = obtenerIdPorUsername($conexion, $username);
            $_SESSION["id"] = $uid;
            checkMisionLogin($conexion, $uid);
            echo json_encode(["success" => true, "redirect" => "/views/app.php"]);
            exit;
        }
    }

    echo json_encode(["success" => false, "message" => "Usuario o contraseña incorrectos."]);
    exit;
?>
