<?php 
    session_start();

    include "../models/conexionDatabase.php";
    include "../models/TablaUsuario.php";
    $conexion = conexion();

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $username = $_POST["username"] ?? "";
        $email = $_POST["email"] ?? "";
        $contrasenya = $_POST["password"] ?? "";
        $nueva_contrasenya = $_POST["nueva_password"] ?? "";

        if($contrasenya !== $nueva_contrasenya)
        {
            echo "Las contraseñas no coinciden";
            exit;
        }

        $usuarios = obtenerDatosVerificacion($conexion);
        
        foreach($usuarios as $u)
        {
            if($email == $u["email"] && $username == $u["username"])
            {
                echo "Usuario ya creado, vuelve al login";
                exit;
            }
        }
        
        crearUsuario($conexion, $username, $email, $contrasenya);
    }
?>