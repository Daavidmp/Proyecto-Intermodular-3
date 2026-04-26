<?php 
    require_once "TablaUsuario.php";
    
    function mostrarMensajesEntreUsuarios($conexion, $emisor_id, $receptor_id)
    {
        $sql = "SELECT * FROM mensajes 
                WHERE (emisor_id = :emisor_id AND receptor_id = :receptor_id) 
                OR (emisor_id = :receptor_id AND receptor_id = :emisor_id)
                ORDER BY fecha_envio ASC";
        
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            "emisor_id" => $emisor_id, 
            "receptor_id" => $receptor_id
        ]);

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    function enviarMensaje($conexion, $emisor_id, $receptor_id, $contenido)
    {
        $sql = "INSERT INTO mensajes (emisor_id, receptor_id, contenido) 
                VALUES (:emisor_id, :receptor_id, :contenido)";
        
        $stmt = $conexion->prepare($sql);
        
        return $stmt->execute([
            "emisor_id" => $emisor_id,
            "receptor_id" => $receptor_id,
            "contenido" => $contenido
        ]);
    }
?>