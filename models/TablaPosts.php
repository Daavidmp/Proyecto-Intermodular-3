<?php 
    require_once "TablaUsuario.php";
    function obtenerPostsTotalesUsuario($conexion, $username)
    {
        $usuario_id = obtenerIdPorUsername($conexion, $username);
        $sql = "SELECT COUNT(*) as total FROM posts WHERE usuario_id = :usuario_id";
        
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $resultado['total'] ?? 0;
    }

    // Metodo para crear un post
    function crearPost($conexion, $usuario_id, $contenido, $image_link, $music_link)
    {
        $likes = 0;
        $ssql = "INSERT INTO posts (usuario_id, contenido, image_link, music_link, likes) VALUES (:usuario_id, :contenido, :image_link, :music_link, :likes)";

        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":contenido", $contenido);
        $stmt->bindParam(":image_link", $image_link);
        $stmt->bindParam(":music_link", $music_link);
        $stmt->bindParam(":likes", $likes);

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

    // Mostrar todos los posts
    function mostrarPosts($conexion)
    {
        $ssql = "SELECT posts.*, usuarios.username, usuarios.avatar_url FROM posts posts INNER JOIN usuarios usuarios ON posts.usuario_id = usuarios.id ORDER BY posts.fecha DESC";

        $stmt = $conexion->prepare($ssql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>