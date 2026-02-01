<?php 
    function obtenerImagenGachaConRareza()
    {
        // Probabilidades
        $probabilidades = [
            'comun' => 60,
            'epico' => 25,
            'legendario' => 15
        ];
        
        // Seleccionar rareza
        $random = mt_rand(1, 100);
        $rarezaSeleccionada = '';
        $acumulado = 0;
        
        foreach ($probabilidades as $rareza => $probabilidad) 
        {
            $acumulado += $probabilidad;
            if ($random <= $acumulado) 
            {
                $rarezaSeleccionada = $rareza;
                break;
            }
        }
        
        // Carpeta de la rareza
        $carpeta = '../img/coleccionables/' . $rarezaSeleccionada . '/';
        
        // Obtener imágenes
        $imagenes = glob($carpeta . '*.{jpg,jpeg,png,gif,webp,avif}', GLOB_BRACE);
        
        if (empty($imagenes)) 
        {
            $carpeta = '../img/coleccionables/comun/';
            $imagenes = glob($carpeta . '*.{jpg,jpeg,png,gif,webp,avif}', GLOB_BRACE);
            
            if (empty($imagenes)) 
            {
                return ['error' => 'No hay imágenes'];
            }
        }
        
        $nombreImagen = basename($imagenes[array_rand($imagenes)]);
        
        // Devuelve nombre y rareza
        return [
            'nombre' => $nombreImagen,
            'rareza' => $rarezaSeleccionada
        ];
    } 

    function guardarRecompensa($conexion, $nombre_imagen, $rareza, $usuario_id)
    {
        $ssql = "INSERT INTO gacha_obtenidos (nombre_imagen, rareza, usuario_id) VALUES (:nombre_imagen, :rareza, :usuario_id)";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":nombre_imagen", $nombre_imagen, PDO::PARAM_STR);
        $stmt->bindParam(":rareza", $rareza, PDO::PARAM_STR);
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR);

        $stmt->execute();
    }

    function mostrarItems($conexion, $usuario_id)
    {
        $ssql = "SELECT nombre_imagen, rareza FROM gacha_obtenidos WHERE usuario_id = :usuario_id";
        $stmt = $conexion->prepare($ssql);
        $stmt->bindParam(":usuario_id", $usuario_id, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>