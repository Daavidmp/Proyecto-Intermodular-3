<?php  
    require_once "../controllers/buscar.php";

    $usuario_actual = $_SESSION["username"];
    
    //Aqui obtengo el id del usuario en sesion
    $emisor_id = obtenerIdPorUsername($conexion, $usuario_actual);
?>
    <div class="mensajes">
        <input type="text" id="buscador" name="buscar" placeholder="Buscar por nombre de usuario">
        <p>Mensajes</p>
        <?php  
            foreach($chat as $usuarios)
            {
                $receptor_id = $usuarios['id']; 
                
                echo "<button class='mensajes__usuarios' data-url='ViewChat.php?receptor_id=" . $receptor_id . "'>";
                echo "<img src='" . $usuarios['avatar_url'] . "'>";
                echo "<p>" . $usuarios["username"] . "</p>";
                echo "</button>";
            }  
        ?>
    </div>