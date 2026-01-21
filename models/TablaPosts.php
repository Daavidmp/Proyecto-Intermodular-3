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

    // Metodo para crear un post
    function crearPost($conexion, $usuario_id, $contenido, $music_link)
    {
        $ssql = "INSERT INTO posts (usuario_id, contenido, music_link) VALUES (:usuario_id, :contenido, :music_link)";

        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":contenido", $contenido);
        $stmt->bindParam(":music_link", $music_link);

        $resultado = $stmt->execute();

        return $resultado;
    }
    // Metodo para mostrar todos los posts de un usuario
    function mostrarPostsDeUnUsuario($conexion, $username)
    {
        $usuario_id = obtenerIdPorUsername($conexion, $username);
        $ssql = "SELECT * FROM posts WHERE usuario_id = :usuario_id ORDER BY fecha DESC";

        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>