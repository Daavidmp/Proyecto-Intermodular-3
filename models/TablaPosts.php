<?php 
    require_once "TablaUsuario.php";
    function obtenerPostsTotales($conexion)
    {
        $resultado = obtenerDatos($conexion);
        $id = $resultado["id"];

        $sql = "SELECT COUNT(*) AS total_posts FROM posts WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalPosts = $resultado['total_posts'];

        return $totalPosts;
    }

    function obtenerPostsTotalesUsuario($conexion, $usuario_id)
    {
        $sql = "SELECT COUNT(*) as total FROM posts WHERE usuario_id = :usuario_id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] ?? 0;
    }
?>