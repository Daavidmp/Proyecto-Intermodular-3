<?php 
    session_start();

    include "../models/conexionDatabase.php";
    require_once "../models/TablaUsuario.php";
    $conexion = conexion();

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $username = $_POST["username"] ?? "";
        $contrasenya = $_POST["password"] ?? "";

        $usuarios = obtenerUsuarioContrasenya($conexion);

        foreach($usuarios as $u)
        {
            if($username == $u["username"] && $contrasenya == $u["contrasenya"])
            {
                $_SESSION["username"] = $username;
                $_SESSION["id"] = obtenerIdPorUsername($conexion, $username);
                header("Location: ../views/formMenu.php");
                exit;
            }
        }
            
        echo "Usuario no encontrado";
        exit; 
    }
?>