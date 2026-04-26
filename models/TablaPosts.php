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

    // FIX #10: eliminados likes y dislikes del INSERT, la BD usa DEFAULT 0
    function crearPost($conexion, $usuario_id, $contenido, $image_link, $music_link)
    {
        $ssql = "INSERT INTO posts (usuario_id, contenido, image_link, music_link) 
                 VALUES (:usuario_id, :contenido, :image_link, :music_link)";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->bindParam(":contenido",  $contenido);
        $stmt->bindParam(":image_link", $image_link);
        $stmt->bindParam(":music_link", $music_link);
        return $stmt->execute();
    }

    function mostrarPostsDeUnUsuario($conexion, $username)
    {
        $usuario_id = obtenerIdPorUsername($conexion, $username);
        $ssql = "SELECT * FROM posts WHERE usuario_id = :usuario_id ORDER BY fecha DESC";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function mostrarPosts($conexion)
    {
        $ssql = "SELECT posts.*, usuarios.username, usuarios.avatar_url FROM posts posts INNER JOIN usuarios usuarios ON posts.usuario_id = usuarios.id ORDER BY posts.fecha DESC";
        $stmt = $conexion->prepare($ssql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function obtenerVotoUsuario($conexion, $usuario_id, $post_id)
    {
        $sql  = "SELECT tipo FROM likes WHERE usuario_id = :uid AND post_id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":uid", $usuario_id);
        $stmt->bindParam(":pid", $post_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row["tipo"] : null;
    }

    function insertarVoto($conexion, $usuario_id, $post_id, $tipo)
    {
        $sql  = "INSERT INTO likes (usuario_id, post_id, tipo) VALUES (:uid, :pid, :tipo)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":uid",  $usuario_id);
        $stmt->bindParam(":pid",  $post_id);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->execute();
    }

    function actualizarVoto($conexion, $usuario_id, $post_id, $tipo)
    {
        $sql  = "UPDATE likes SET tipo = :tipo WHERE usuario_id = :uid AND post_id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":tipo", $tipo);
        $stmt->bindParam(":uid",  $usuario_id);
        $stmt->bindParam(":pid",  $post_id);
        $stmt->execute();
    }

    function eliminarVoto($conexion, $usuario_id, $post_id)
    {
        $sql  = "DELETE FROM likes WHERE usuario_id = :uid AND post_id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":uid", $usuario_id);
        $stmt->bindParam(":pid", $post_id);
        $stmt->execute();
    }

    function cambiarContadorLikes($conexion, $post_id, $delta)
    {
        $sql  = "UPDATE posts SET likes = GREATEST(0, COALESCE(likes,0) + :delta) WHERE id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":delta", $delta, PDO::PARAM_INT);
        $stmt->bindParam(":pid",   $post_id);
        $stmt->execute();
    }

    function cambiarContadorDislikes($conexion, $post_id, $delta)
    {
        $sql  = "UPDATE posts SET dislikes = GREATEST(0, COALESCE(dislikes,0) + :delta) WHERE id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":delta", $delta, PDO::PARAM_INT);
        $stmt->bindParam(":pid",   $post_id);
        $stmt->execute();
    }

    function obtenerTotalesPost($conexion, $post_id)
    {
        $sql  = "SELECT likes, dislikes FROM posts WHERE id = :pid";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":pid", $post_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function obtenerVotosUsuarioEnPosts($conexion, $usuario_id, $post_ids)
    {
        if (empty($post_ids)) return [];
        $placeholders = implode(",", array_fill(0, count($post_ids), "?"));
        $sql  = "SELECT post_id::text, tipo FROM likes WHERE usuario_id = ? AND post_id::text IN ($placeholders)";
        $stmt = $conexion->prepare($sql);
        $params = array_merge([$usuario_id], array_map('strval', $post_ids));
        $stmt->execute($params);
        $map = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $map[$row["post_id"]] = $row["tipo"];
        }
        return $map;
    }
?>
