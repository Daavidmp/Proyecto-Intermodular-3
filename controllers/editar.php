<?php 
    session_start();

    include "../models/conexionDatabase.php";
    $username_actual = $_SESSION["username"];
    $conexion = conexion();

    if($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $nuevo_username = $_POST["username"] ?? "";
        $avatar_url = $_POST["avatar_url"] ?? "";
        $biografia = $_POST["biografia"] ?? "";
        $contrasenya = $_POST["contrasenya"] ?? "";
        $email = $_POST["email"] ?? "";
        $ubicacion = $_POST["ubicacion"] ?? "";
        $enlace_spoty = $_POST["enlace_spoty"] ?? "";
        
        $sql = "UPDATE usuarios SET username = :nuevo_username, avatar_url = :avatar_url, biografia = :biografia, email = :email, ubicacion = :ubicacion, enlace_spoty = :enlace_spoty";
        
        $params = [
            ':nuevo_username' => $nuevo_username,
            ':avatar_url' => $avatar_url,
            ':biografia' => $biografia,
            ':email' => $email,
            ':ubicacion' => $ubicacion,
            ':enlace_spoty' => $enlace_spoty,
            ':username_actual' => $username_actual
        ];
        
        $sql = "UPDATE usuarios SET username = :nuevo_username, avatar_url = :avatar_url, biografia = :biografia, email = :email, ubicacion = :ubicacion, enlace_spoty = :enlace_spoty WHERE username = :username_actual";
        
        $stmt = $conexion->prepare($sql);
        
        if($stmt->execute($params)) 
        {   
            header("Location: ../views/formMenu.php");
            exit;
        } 
        else 
        {
            echo "Error al actualizar el perfil.";
        }
    } 
?>