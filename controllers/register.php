<?php 
    session_start();
    header('Content-Type: application/json');

    require_once "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    $conexion = conexion();

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        echo json_encode(["success" => false, "message" => "Método no permitido."]);
        exit;
    }

    $username          = trim($_POST["username"]      ?? "");
    $email             = trim($_POST["email"]         ?? "");
    $contrasenya       = $_POST["password"]           ?? "";
    $nueva_contrasenya = $_POST["nueva_password"]     ?? "";

    // Validaciones
    if ($username === "" || $email === "" || $contrasenya === "") {
        echo json_encode(["success" => false, "message" => "Rellena todos los campos."]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "message" => "El correo electrónico no es válido."]);
        exit;
    }

    if (strlen($contrasenya) < 6) {
        echo json_encode(["success" => false, "message" => "La contraseña debe tener al menos 6 caracteres."]);
        exit;
    }

    if ($contrasenya !== $nueva_contrasenya) {
        echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden."]);
        exit;
    }

    $usuarios = obtenerDatosVerificacion($conexion);

    foreach ($usuarios as $u) {
        if ($username === $u["username"]) {
            echo json_encode(["success" => false, "message" => "Ese nombre de usuario ya está en uso."]);
            exit;
        }
        if ($email === $u["email"]) {
            echo json_encode(["success" => false, "message" => "Ese correo ya tiene una cuenta asociada."]);
            exit;
        }
    }

    crearUsuario($conexion, $username, $email, $contrasenya);
    echo json_encode(["success" => true, "redirect" => "/views/formLogin.php", "message" => "¡Cuenta creada! Ahora inicia sesión."]);
    exit;
?>