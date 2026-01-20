<?php
include "../models/conexionDatabase.php";

try 
{
    $db = conexion();
    
    $version = $db->query('SELECT version()')->fetchColumn();
    
    echo "<b>¡Conexión exitosa!</b><br>";
    echo "Servidor conectado a: " . $version;
} 
catch (Exception $e) 
{
    echo "<b>Error en la conexión:</b> " . $e->getMessage();
}
?>