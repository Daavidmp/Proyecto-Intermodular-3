<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();

    require_once __DIR__ . "/../models/conexionDatabase.php";
    require_once __DIR__ . "/../models/TablaUsuario.php";
    require_once __DIR__ . "/../models/TablaGacha.php";

    $conexion   = conexion();
    $usuario    = $_SESSION["username"];
    $usuario_id = $_SESSION["id"];
    $saldoTotal = mostrarSaldo($conexion, $usuario_id);

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        if (isset($_POST["accion"]) && $_POST["accion"] == "banner" && isset($_POST["nombre_imagen"]))
        {
            actualizarBanner($conexion, $usuario_id, $_POST["nombre_imagen"]);
            echo "Banner actualizado";
            exit;
        }

        if (isset($_POST["accion"]) && $_POST["accion"] == "equiparCursor" && isset($_POST["nombre_cursor"]))
        {
            equiparCursor($conexion, $usuario_id, $_POST["nombre_cursor"]);
            echo json_encode(["success" => true]);
            exit;
        }

        if (isset($_POST["accion"]) && $_POST["accion"] == "quitarCursor")
        {
            equiparCursor($conexion, $usuario_id, null);
            echo json_encode(["success" => true]);
            exit;
        }

        if (isset($_POST["accion"]) && $_POST["accion"] == "tirarGacha")
        {
            if ($saldoTotal >= 10)
            {
                descontarMonedas($conexion, $saldoTotal, $usuario_id);

                // 30% cursores, 70% banners
                $tipoPremio = mt_rand(1, 100) <= 30 ? 'cursor' : 'banner';

                if ($tipoPremio === 'cursor') {
                    $datos = obtenerCursorGachaConRareza($conexion, $usuario_id);
                    if (!isset($datos["error"])) {
                        guardarCursor($conexion, $datos["nombre"], $datos["rareza"], $usuario_id);
                        echo json_encode([
                            "success"  => true,
                            "tipo"     => "cursor",
                            "nombre"   => $datos["nombre"],
                            "rareza"   => $datos["rareza"],
                            "repetida" => false,
                            "message"  => "¡Cursor obtenido!"
                        ]);
                        exit;
                    }
                    // Cursores completos → intentar con banner
                    if (($datos["error"] ?? '') === 'coleccion_completa') {
                        $tipoPremio = 'banner'; // fallback a banner
                    }
                }

                // Banner
                $datos_gacha = obtenerImagenGachaConRareza($conexion, $usuario_id);

                if (isset($datos_gacha["error"])) {
                    // Colección completamente llena → devolver monedas
                    $stmt = $conexion->prepare("UPDATE usuarios SET saldo = saldo + 10 WHERE id = :uid");
                    $stmt->execute([':uid' => $usuario_id]);
                    echo json_encode([
                        "success" => false,
                        "message" => $datos_gacha["message"] ?? "¡Ya tienes toda la colección! Se te han devuelto las monedas."
                    ]);
                    exit;
                }

                guardarRecompensa($conexion, $datos_gacha["nombre"], $datos_gacha["rareza"], $usuario_id);

                echo json_encode([
                    "success"  => true,
                    "tipo"     => "banner",
                    "nombre"   => $datos_gacha["nombre"],
                    "rareza"   => $datos_gacha["rareza"],
                    "repetida" => false,
                    "message"  => "¡Gacha completado!"
                ]);
            }
            else
            {
                echo json_encode([
                    "success" => false,
                    "message" => "Saldo insuficiente. Necesitas 10 monedas. (Tienes: $saldoTotal)"
                ]);
            }
            exit;
        }
    }

    $itemsUsuario   = mostrarItems($conexion, $usuario_id);
    $miBanner       = obtenerBannerDeMiUsuario($conexion, $usuario_id);
    $misCursores    = obtenerCursoresUsuario($conexion, $usuario_id);
    $cursorActivo   = obtenerCursorActivo($conexion, $usuario_id);
?>