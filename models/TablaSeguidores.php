<?php 
    require_once "TablaUsuario.php";
    
    function obtenerSiguiendo($conexion)
    {
        $resultado = obtenerDatos($conexion);
        $id = $resultado["id"];

        $sqlReceptor = "SELECT COUNT(*) AS total_receptores FROM seguidores WHERE receptor_id = :id";
        $stmt = $conexion->prepare($sqlReceptor);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalReceptores = $resultado['total_receptores'];

        return $totalReceptores;
    }

    function obtenerSeguidores($conexion)
    {
        $resultado = obtenerDatos($conexion);
        $id = $resultado["id"];

        $sqlSeguidor = "SELECT COUNT(*) AS total_seguidores FROM seguidores WHERE seguidor_id = :id";

        $stmt = $conexion->prepare($sqlSeguidor);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalSeguidores = $resultado['total_seguidores'];

        return $totalSeguidores;
    }

    //Total
    function obtenerSiguiendoUsuario($conexion, $usuario_id)
    {
        $sql = "SELECT COUNT(*) as total FROM seguidores WHERE seguidor_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] ?? 0;
    }

    function obtenerSeguidoresUsuario($conexion, $usuario_id)
    {
        $sql = "SELECT COUNT(*) as total FROM seguidores WHERE seguidor_id = :usuario_id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] ?? 0;
    }
?>