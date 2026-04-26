<?php 
if (!function_exists('conexion')) {
    function conexion()
    {
        $host = "aws-1-eu-central-2.pooler.supabase.com";
        $db   = "postgres";
        $user = "postgres.oifhvkggmhyetqtimvnl";
        $pass = "o6i1q1I9RrsH5fkn";
        $port = "5432";

        try
        {
            $conexion = new PDO("pgsql:host=$host;port=$port;dbname=$db;sslmode=require", $user, $pass);

            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conexion;
        }
        catch (PDOException $e)
        {
            echo "Error de conexión: " . $e->getMessage();
            exit;
        }
    }
}