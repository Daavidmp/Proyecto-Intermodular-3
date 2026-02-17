<?php 
    function mostrarMisiones($conexion)
    {
        $ssql = "SELECT nombre, descripcion, icono, fecha FROM logros ORDER BY fecha";
        $stmt = $conexion->prepare($ssql);
        $stmt->execute();

        $logros = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $logros;
    }
?>