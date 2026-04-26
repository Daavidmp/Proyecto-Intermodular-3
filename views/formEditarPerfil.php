<?php 
    if (session_status() === PHP_SESSION_NONE) session_start();
    if(!isset($_SESSION["username"]))
    {
        header("Location: formLogin.php");
        exit;
    }
    
    include "../models/conexionDatabase.php";
    $conexion = conexion();
    
    $sql = "SELECT username, avatar_url, biografia, email, ubicacion, enlace_spoty FROM usuarios WHERE username = :username";
    
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':username', $_SESSION["username"]);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="form">
    <form action="/controllers/editar.php" method="post">
        <h1 class="form__titulo">Editar Perfil</h1>
        <label for="username" class="form__label">Usuario</label>
        <input type="text" name="username" class="form__input" value="<?php echo $usuario['username']; ?>">

        <label for="avatar_url" class="form__label">Foto de Perfil</label>
        <input type="text" name="avatar_url" class="form__input" value="<?php echo $usuario['avatar_url']; ?>">

        <label for="biografia" class="form__label">Biografia</label>
        <input type="text" name="biografia" class="form__input" value="<?php echo $usuario['biografia']; ?>">

        <label for="contrasenya" class="form__label">Contraseña (dejala en blanco para no cambiarla)</label>
        <input type="password" name="contrasenya" class="form__input">

        <label for="email" class="form__label">Correo Electronico</label>
        <input type="email" name="email" class="form__input" value="<?php echo $usuario['email']; ?>">

        <label for="ubicacion" class="form__label">Ubicación</label>
        <input type="text" name="ubicacion" class="form__input" value="<?php echo $usuario['ubicacion']; ?>">

        <label for="enlace_spoty" class="form__label">Enlace Spotify</label>
        <input type="text" name="enlace_spoty" class="form__input" value="<?php echo $usuario['enlace_spoty']; ?>">

        <button type="submit" id="btn__form__editar">Guardar Cambios</button>
    </form>
</div>