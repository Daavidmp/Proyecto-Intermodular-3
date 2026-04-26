<?php

    /* ============================================================
       MISIONES - usa logros_obtenidos (esquema real)
       ============================================================ */

    function mostrarMisiones($conexion)
    {
        $ssql = "SELECT id, nombre, descripcion, icono, fecha, 
                        COALESCE(puntos, 0) AS puntos, 
                        COALESCE(dificultad, 'facil') AS dificultad 
                 FROM logros ORDER BY COALESCE(puntos, 0) ASC";
        $stmt = $conexion->prepare($ssql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Misiones con estado para el usuario en sesión
     * Usa logros_obtenidos (tabla real)
     */
    function mostrarMisionesConEstado($conexion, $usuario_id)
    {
        $ssql = "SELECT l.id, l.nombre, l.descripcion, l.icono,
                        COALESCE(l.puntos, 0)      AS puntos,
                        COALESCE(l.dificultad, 'facil') AS dificultad,
                        lo.fecha_completado,
                        lo.recompensa_recogida
                 FROM logros l
                 LEFT JOIN logros_obtenidos lo
                        ON l.id = lo.logro_id AND lo.usuario_id = :usuario_id
                 ORDER BY COALESCE(l.puntos, 0) ASC";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marca una misión como completada en logros_obtenidos y crea notificación
     * Devuelve true si se insertó, false si ya existía
     */
    function completarMision($conexion, $usuario_id, $logro_id)
    {
        // ¿Ya completada?
        $check = $conexion->prepare(
            "SELECT logro_id FROM logros_obtenidos 
             WHERE usuario_id = :uid AND logro_id = :lid"
        );
        $check->execute([':uid' => $usuario_id, ':lid' => $logro_id]);
        if ($check->fetch()) return false;

        // Insertar
        $stmt = $conexion->prepare(
            "INSERT INTO logros_obtenidos (usuario_id, logro_id, recompensa_recogida)
             VALUES (:uid, :lid, FALSE)"
        );
        $stmt->execute([':uid' => $usuario_id, ':lid' => $logro_id]);

        // Notificación
        $info = $conexion->prepare(
            "SELECT nombre, COALESCE(puntos,0) AS puntos FROM logros WHERE id = :lid"
        );
        $info->execute([':lid' => $logro_id]);
        $mision = $info->fetch(PDO::FETCH_ASSOC);
        if ($mision) {
            crearNotificacionMision($conexion, $usuario_id, $mision['nombre'], $mision['puntos'], $logro_id);
        }
        return true;
    }

    /**
     * Recoge la recompensa: suma MRTNs al saldo y marca recompensa_recogida = TRUE
     */
    function recogerRecompensa($conexion, $usuario_id, $logro_id)
    {
        $check = $conexion->prepare(
            "SELECT lo.logro_id, COALESCE(l.puntos,0) AS puntos
             FROM logros_obtenidos lo
             JOIN logros l ON lo.logro_id = l.id
             WHERE lo.usuario_id = :uid AND lo.logro_id = :lid 
               AND lo.recompensa_recogida = FALSE"
        );
        $check->execute([':uid' => $usuario_id, ':lid' => $logro_id]);
        $row = $check->fetch(PDO::FETCH_ASSOC);
        if (!$row) return ['success' => false, 'error' => 'Recompensa no disponible'];

        $puntos = (int)$row['puntos'];

        // Marcar como recogida
        $upd = $conexion->prepare(
            "UPDATE logros_obtenidos SET recompensa_recogida = TRUE
             WHERE usuario_id = :uid AND logro_id = :lid"
        );
        $upd->execute([':uid' => $usuario_id, ':lid' => $logro_id]);

        // Sumar al saldo
        $sal = $conexion->prepare(
            "UPDATE usuarios SET saldo = COALESCE(saldo,0) + :puntos WHERE id = :uid"
        );
        $sal->execute([':puntos' => $puntos, ':uid' => $usuario_id]);

        return ['success' => true, 'puntos' => $puntos];
    }

    /* ============================================================
       NOTIFICACIONES
       ============================================================ */

    function crearNotificacionMision($conexion, $usuario_id, $nombre_mision, $puntos, $logro_id)
    {
        $stmt = $conexion->prepare(
            "INSERT INTO notificaciones (usuario_id, tipo, titulo, descripcion, dato_extra)
             VALUES (:uid, 'mision', :titulo, :desc, :extra)"
        );
        $stmt->execute([
            ':uid'    => $usuario_id,
            ':titulo' => '¡Misión completada!',
            ':desc'   => '«' . $nombre_mision . '» — Recompensa: ' . $puntos . ' MRTNs',
            ':extra'  => $logro_id,
        ]);
    }

    function crearNotificacionMensaje($conexion, $receptor_id, $emisor_username, $emisor_id)
    {
        // Evitar spam: no crear si ya hay una sin leer del mismo emisor en los últimos 2 min
        $dup = $conexion->prepare(
            "SELECT id FROM notificaciones
             WHERE usuario_id = :uid AND tipo = 'mensaje' AND dato_extra = :eid
               AND leida = FALSE AND fecha > NOW() - INTERVAL '2 minutes'"
        );
        $dup->execute([':uid' => $receptor_id, ':eid' => (string)$emisor_id]);
        if ($dup->fetch()) return;

        $stmt = $conexion->prepare(
            "INSERT INTO notificaciones (usuario_id, tipo, titulo, descripcion, dato_extra)
             VALUES (:uid, 'mensaje', :titulo, :desc, :extra)"
        );
        $stmt->execute([
            ':uid'    => $receptor_id,
            ':titulo' => 'Nuevo mensaje',
            ':desc'   => $emisor_username . ' te ha enviado un mensaje',
            ':extra'  => (string)$emisor_id,
        ]);
    }

    function obtenerNotificaciones($conexion, $usuario_id)
    {
        $ssql = "SELECT n.*,
                        CASE WHEN n.tipo = 'mensaje' THEN u.avatar_url ELSE NULL END AS emisor_avatar,
                        CASE WHEN n.tipo = 'mensaje' THEN u.username   ELSE NULL END AS emisor_username
                 FROM notificaciones n
                 LEFT JOIN usuarios u ON n.tipo = 'mensaje' AND u.id::text = n.dato_extra
                 WHERE n.usuario_id = :uid
                 ORDER BY n.fecha DESC
                 LIMIT 30";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function contarNotificacionesSinLeer($conexion, $usuario_id)
    {
        $stmt = $conexion->prepare(
            "SELECT COUNT(*) FROM notificaciones WHERE usuario_id = :uid AND leida = FALSE"
        );
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    function marcarNotificacionesLeidas($conexion, $usuario_id)
    {
        $stmt = $conexion->prepare(
            "UPDATE notificaciones SET leida = TRUE WHERE usuario_id = :uid AND leida = FALSE"
        );
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();
    }

    /* ============================================================
       CHECKS AUTOMÁTICOS DE MISIONES
       ============================================================ */

    function _completarPorNombre($conexion, $usuario_id, $nombre)
    {
        $stmt = $conexion->prepare("SELECT id FROM logros WHERE nombre = :n LIMIT 1");
        $stmt->execute([':n' => $nombre]);
        $logro = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($logro) completarMision($conexion, $usuario_id, $logro['id']);
    }

    function checkMisionLogin($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Iniciar sesion');
    }

    function checkMisionesSeguir($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Seguir a una persona');
    }

    function checkMisionPublicar($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Romper el silencio');
    }

    function checkMisionLike($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Señal de Afinidad');
    }

    function checkMisionDislike($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Voto de Contraste');
    }

    function checkMisionGacha($conexion, $usuario_id)
    {
        _completarPorNombre($conexion, $usuario_id, 'Apuesta al Destino');
    }

    /**
     * Comprueba hitos de seguidores.
     * La tabla seguidores usa receptor_id (no seguido_id)
     */
    function checkMisionesSeguidores($conexion, $usuario_id)
    {
        $stmt = $conexion->prepare(
            "SELECT COUNT(*) FROM seguidores WHERE receptor_id = :uid"
        );
        $stmt->bindParam(':uid', $usuario_id, PDO::PARAM_STR);
        $stmt->execute();
        $total = (int)$stmt->fetchColumn();

        $hitos = [
            1      => 'Tu primer fan',
            10     => 'Los primeros 10 seguidores',
            100    => 'Los Primeros 100 Seguidores',
            1000   => 'Tu Primera Comunidad (1K Seguidores)',
            100000 => 'Creador Establecido (100K Seguidores)',
        ];
        foreach ($hitos as $cantidad => $nombre) {
            if ($total >= $cantidad) {
                _completarPorNombre($conexion, $usuario_id, $nombre);
            }
        }
    }
?>
