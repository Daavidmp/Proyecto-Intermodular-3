<?php 
    session_start();

    include "../models/conexionDatabase.php";
    $username_actual = $_SESSION["username"];
    $conexion = conexion();

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        $nuevo_username = $_POST["username"]    ?? "";
        $avatar_url     = $_POST["avatar_url"]  ?? "";
        $biografia      = $_POST["biografia"]   ?? "";
        $email          = $_POST["email"]       ?? "";
        $ubicacion      = $_POST["ubicacion"]   ?? "";
        $enlace_spoty   = $_POST["enlace_spoty"] ?? "";

        // FIX #3: eliminada la primera asignación duplicada de $sql que no se ejecutaba
        $sql = "UPDATE usuarios 
                SET username = :nuevo_username, avatar_url = :avatar_url, 
                    biografia = :biografia, email = :email, 
                    ubicacion = :ubicacion, enlace_spoty = :enlace_spoty 
                WHERE username = :username_actual";

        $params = [
            ':nuevo_username' => $nuevo_username,
            ':avatar_url'     => $avatar_url,
            ':biografia'      => $biografia,
            ':email'          => $email,
            ':ubicacion'      => $ubicacion,
            ':enlace_spoty'   => $enlace_spoty,
            ':username_actual' => $username_actual,
        ];

        $stmt = $conexion->prepare($sql);

        if ($stmt->execute($params)) 
        {   
            header("Location: /views/app.php");
            exit;
        } 
        else 
        {
            echo "Error al actualizar el perfil.";
        }
    } 
?>
