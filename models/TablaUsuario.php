<?php 
    function obtenerDatosVerificacion($conexion)
    {
        $sql = "SELECT username, email, contrasenya FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }

    function crearUsuario($conexion, $username, $email, $contrasenya) 
    {
        $sql = "INSERT INTO usuarios (username, email, contrasenya, saldo) VALUES (:username, :email, :contrasenya, :saldo)";
        $stmt = $conexion->prepare($sql);
    
        $stmt->execute([':username' => $username, ':email' => $email,
            ':contrasenya' => $contrasenya, ':saldo' => 0
        ]);
            
        echo "Usuario insertado correctamente.<br>";
        $_SESSION["username"] = $username;

        header("Location: ../views/formMenu.php");
        exit;
    }

    function listarUsuarios($conexion)
    {
        $sql = "SELECT * FROM usuarios ORDER BY username";
        $stmt = $conexion->query($sql);

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function obtenerUsuarioContrasenya($conexion)
    {
        $sql = "SELECT username, contrasenya FROM usuarios";
        $stmt = $conexion->prepare($sql);
        $stmt->execute();

        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $usuarios;
    }

    function obtenerDatos($conexion)
    {
        $usuario = $_SESSION["username"];

        $sql = "SELECT id, biografia, avatar_url, ubicacion, fecha, enlace_spoty FROM usuarios WHERE username = :usuario";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }

    //Metodos para obtencion de usuario que no es el mio

    function obtenerDatosUsuario($conexion, $usuario)
    {
        $sql = "SELECT * FROM usuarios WHERE username = :usuario"; 

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }

    function obtenerUsuarioPorId($conexion, $id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";

        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);

        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }

    //metodo para obtener el id por el nombre del usuario
    function obtenerIdPorUsername($conexion, $username)
    {
        $sql = "SELECT id FROM usuarios WHERE username = :username";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        
        $id = $stmt->fetchColumn();
        return $id;
    }

    function mostrarSaldo($conexion, $id)
    {
        $ssql = "SELECT saldo FROM usuarios WHERE id = :id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $saldo = $stmt->fetchColumn();
        return $saldo;
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
        $ssql = "SELECT u.banner, g.rareza FROM usuarios u INNER JOIN gacha_obtenidos g ON u.id = g.usuario_id AND u.banner = g.nombre_imagen
        WHERE u.id = :id";

        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();

        $banner = $stmt->fetch(PDO::FETCH_ASSOC);
        return $banner;
    }
?>