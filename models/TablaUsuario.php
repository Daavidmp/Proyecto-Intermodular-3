<?php 
    function obtenerDatosVerificacion($conexion)
    {
        $sql = "SELECT username, email, contrasenya FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // FIX #1: Eliminado echo, header y exit. Solo inserta.
    // FIX #2: Contraseña hasheada con password_hash.
    // FIX #12: CURRENT_TIME → CURRENT_TIMESTAMP.
    function crearUsuario($conexion, $username, $email, $contrasenya) 
    {
        $sql = "INSERT INTO usuarios (username, email, contrasenya, saldo, fecha) 
                VALUES (:username, :email, :contrasenya, :saldo, CURRENT_TIMESTAMP)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':username'    => $username,
            ':email'       => $email,
            ':contrasenya' => password_hash($contrasenya, PASSWORD_DEFAULT),
            ':saldo'       => 0,
        ]);
    }

    function listarUsuarios($conexion)
    {
        $sql = "SELECT * FROM usuarios ORDER BY username";
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerUsuarioContrasenya($conexion)
    {
        $sql = "SELECT username, contrasenya FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerDatos($conexion)
    {
        $usuario = $_SESSION["username"];
        $sql = "SELECT id, biografia, avatar_url, ubicacion, fecha, enlace_spoty FROM usuarios WHERE username = :usuario";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerDatosUsuario($conexion, $usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :usuario"; 
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerUsuarioPorId($conexion, $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerIdPorUsername($conexion, $username)
    {
        $sql = "SELECT id FROM usuarios WHERE username = :username";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function mostrarSaldo($conexion, $id)
    {
        $ssql = "SELECT saldo FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function descontarMonedas($conexion, $saldo, $id)
    {
        $saldoTotal = $saldo - 10;
        $ssql = "UPDATE usuarios SET saldo = :saldo WHERE id = :id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":saldo", $saldoTotal, PDO::PARAM_INT);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    function actualizarBanner($conexion, $id, $banner)
    {
        $ssql = "UPDATE usuarios SET banner = :banner WHERE id = :id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":banner", $banner, PDO::PARAM_STR);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    function obtenerBannerDeMiUsuario($conexion, $id)
    {
        $ssql = "SELECT u.banner, g.rareza 
                 FROM usuarios u 
                 LEFT JOIN gacha_obtenidos g ON u.id = g.usuario_id AND u.banner = g.nombre_imagen
                 WHERE u.id = :id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        $banner = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($banner === false) {
            $banner = ['banner' => null, 'rareza' => null];
        }
        return $banner;
    }
?>
