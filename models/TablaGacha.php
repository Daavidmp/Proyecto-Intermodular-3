<?php
    function obtenerCursoresUsuario($conexion, $usuario_id) {
        try {
            $stmt = $conexion->prepare(
                "SELECT nombre_cursor, rareza FROM cursores_obtenidos WHERE usuario_id = :uid ORDER BY rareza DESC"
            );
            $stmt->execute([':uid' => $usuario_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if ($e->getCode() === '42P01' || strpos($e->getMessage(), 'cursores_obtenidos') !== false) return [];
            throw $e;
        }
    }

    function equiparCursor($conexion, $usuario_id, $nombre_cursor) {
        try {
            $stmt = $conexion->prepare("UPDATE usuarios SET cursor_activo = :c WHERE id = :uid");
            $stmt->execute([':c' => $nombre_cursor, ':uid' => $usuario_id]);
        } catch (PDOException $e) {
            if ($e->getCode() === '42703' || strpos($e->getMessage(), 'cursor_activo') !== false) return;
            throw $e;
        }
    }

    function obtenerCursorActivo($conexion, $usuario_id) {
        try {
            $stmt = $conexion->prepare("SELECT cursor_activo FROM usuarios WHERE id = :uid");
            $stmt->execute([':uid' => $usuario_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            if ($e->getCode() === '42703' || strpos($e->getMessage(), 'cursor_activo') !== false) return null;
            throw $e;
        }
    }

    function mostrarItems($conexion, $usuario_id) {
        try {
            $stmt = $conexion->prepare("SELECT nombre_imagen, rareza FROM gacha_obtenidos WHERE usuario_id = :uid");
            $stmt->execute([':uid' => $usuario_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            if ($e->getCode() === '42P01' || strpos($e->getMessage(), 'gacha_obtenidos') !== false) return [];
            throw $e;
        }
    }

    /* ─────────────────────────────────────────────────────────
       Devuelve los nombres de banners/cursores que el usuario YA TIENE
    ───────────────────────────────────────────────────────── */
    function _obtenerBannersYaTenidos($conexion, $usuario_id) {
        try {
            $stmt = $conexion->prepare("SELECT nombre_imagen FROM gacha_obtenidos WHERE usuario_id = :uid");
            $stmt->execute([':uid' => $usuario_id]);
            return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'nombre_imagen');
        } catch (Exception $e) { return []; }
    }

    function _obtenerCursoresYaTenidos($conexion, $usuario_id) {
        try {
            $stmt = $conexion->prepare("SELECT nombre_cursor FROM cursores_obtenidos WHERE usuario_id = :uid");
            $stmt->execute([':uid' => $usuario_id]);
            return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'nombre_cursor');
        } catch (Exception $e) { return []; }
    }

    /* ─────────────────────────────────────────────────────────
       BANNERS: selección sin repetidos.
       Intenta la rareza sorteada; si todo está repetido en esa
       rareza sube al siguiente nivel hasta encontrar algo nuevo.
       Si la colección entera está completa devuelve el flag
       "coleccion_completa" para informar al jugador.
    ───────────────────────────────────────────────────────── */
    function obtenerImagenGachaConRareza($conexion, $usuario_id) {
        $rand = mt_rand(1, 100);
        if      ($rand <= 60) $rareza = 'comun';
        elseif  ($rand <= 88) $rareza = 'epico';
        else                  $rareza = 'legendario';

        $yasTenidos  = _obtenerBannersYaTenidos($conexion, $usuario_id);
        $orden       = ['comun', 'epico', 'legendario'];
        $inicio      = array_search($rareza, $orden);
        $rutaBase    = __DIR__ . "/../img/coleccionables/";

        // Recorre desde la rareza sorteada hacia arriba buscando algo nuevo
        for ($i = $inicio; $i < count($orden); $i++) {
            $r        = $orden[$i];
            $dir      = $rutaBase . $r;
            if (!is_dir($dir)) continue;

            $archivos = array_values(array_filter(scandir($dir), fn($f) => !in_array($f, ['.', '..'])));
            $nuevos   = array_values(array_diff($archivos, $yasTenidos));

            if (!empty($nuevos)) {
                $nombre = $nuevos[array_rand($nuevos)];
                return ["nombre" => $nombre, "rareza" => $r, "repetida" => false];
            }
        }

        // Si todo está repetido, informa al jugador (se devuelven monedas en el controller)
        return ["error" => "coleccion_completa", "message" => "¡Ya tienes todos los banners! Pronto habrá más."];
    }

    function guardarRecompensa($conexion, $nombre, $rareza, $usuario_id) {
        try {
            $stmt = $conexion->prepare(
                "INSERT INTO gacha_obtenidos (usuario_id, nombre_imagen, rareza)
                 VALUES (:uid, :img, :rz)
                 ON CONFLICT DO NOTHING"
            );
            $stmt->execute([':uid' => $usuario_id, ':img' => $nombre, ':rz' => $rareza]);
        } catch (PDOException $e) { /* silencioso */ }
    }

    /* ─────────────────────────────────────────────────────────
       CURSORES: igual que banners, sin repetidos
    ───────────────────────────────────────────────────────── */
    function obtenerCursorGachaConRareza($conexion, $usuario_id) {
        $rutaBase = __DIR__ . "/../img/cursores";
        if (!is_dir($rutaBase)) return ["error" => "No existe directorio de cursores"];

        $todos       = array_values(array_filter(scandir($rutaBase), fn($f) => str_ends_with($f, '.svg') || str_ends_with($f, '.png')));
        $yaTenidos   = _obtenerCursoresYaTenidos($conexion, $usuario_id);
        $disponibles = array_values(array_diff($todos, $yaTenidos));

        if (empty($disponibles)) {
            return ["error" => "coleccion_completa", "message" => "¡Ya tienes todos los cursores! Pronto habrá más."];
        }

        $rand = mt_rand(1, 100);
        if      ($rand <= 60) $rareza = 'comun';
        elseif  ($rand <= 88) $rareza = 'epico';
        else                  $rareza = 'legendario';

        $nombre = $disponibles[array_rand($disponibles)];

        return ["nombre" => $nombre, "rareza" => $rareza, "repetida" => false];
    }

    function guardarCursor($conexion, $nombre, $rareza, $usuario_id) {
        try {
            $stmt = $conexion->prepare(
                "INSERT INTO cursores_obtenidos (usuario_id, nombre_cursor, rareza)
                 VALUES (:uid, :nc, :rz)
                 ON CONFLICT DO NOTHING"
            );
            $stmt->execute([':uid' => $usuario_id, ':nc' => $nombre, ':rz' => $rareza]);
        } catch (PDOException $e) { /* silencioso */ }
    }
?>