<?php 
    require_once "TablaUsuario.php";

    // FIX #7: eliminadas obtenerSiguiendo() y obtenerSeguidores() obsoletas
    // que accedían a sesión desde el modelo y eran redundantes.

    // FIX #4: obtenerSiguiendoUsuario usa seguidor_id (cuántos sigo yo)
    function obtenerSiguiendoUsuario($conexion, $usuario_id)
    {
        $sql = "SELECT COUNT(*) as total FROM seguidores WHERE seguidor_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    // FIX #4: obtenerSeguidoresUsuario usa receptor_id (cuántos me siguen a mí)
    function obtenerSeguidoresUsuario($conexion, $usuario_id)
    {
        $sql = "SELECT COUNT(*) as total FROM seguidores WHERE receptor_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] ?? 0;
    }

    function seguirUsuario($conexion, $seguidor_id, $receptor_id)
    {
        $ssql = "INSERT INTO seguidores (seguidor_id, receptor_id) VALUES (:seguidor_id, :receptor_id)";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":seguidor_id", $seguidor_id, PDO::PARAM_STR);
        $stmt->bindParam(":receptor_id", $receptor_id, PDO::PARAM_STR);
        return $stmt->execute();
    }

    function esSeguidor($conexion, $receptor_id, $seguidor_id)
    {
        $ssql = "SELECT COUNT(*) FROM seguidores WHERE receptor_id = :receptor_id AND seguidor_id = :seguidor_id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":seguidor_id", $seguidor_id, PDO::PARAM_STR);
        $stmt->bindParam(":receptor_id", $receptor_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    function listarUsuariosALosQueSigo($conexion, $id)
    {
        $ssql = "SELECT u.id, u.username, u.avatar_url, u.biografia 
                FROM seguidores s 
                INNER JOIN usuarios u ON s.seguidor_id = u.id 
                WHERE s.receptor_id = :id 
                ORDER BY s.fecha DESC";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>
