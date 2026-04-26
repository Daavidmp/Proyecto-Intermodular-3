<?php 
    require_once "../controllers/buscar.php";
?>
    <div class="explorar">
        <h1>Buscar Personas</h1>
        <p>Descubre usuarios que tengan los mismos gustos musicales que tu</p>
        <input type="text" id="buscador" name="buscar" placeholder="Buscar por nombre de usuario">
        
        <!-- LOS USUARIOS DEBEN ESTAR DENTRO DE .explorar -->
        <div class="explorar__usuarios" id="lista-usuarios">
            <?php 
                if(empty($resultado)) 
                {
                    echo "<p class='no-resultados'>No hay usuarios para mostrar</p>";
                } 
                else 
                {
                    foreach($resultado as $usuario) 
                    {
                        echo "<div class='usuario-item'>";
                        echo "<button class='explorar__usuarios__boton' onclick=\"loadSection('/views/ViewVerUsuario.php?username=" . $usuario['username'] . "')\">";
                        echo "<img src='" . (!empty($usuario['avatar_url']) ? $usuario['avatar_url'] : '../img/iconodefault.jpg') . "' 
                        alt='" . $usuario['username'] . "'onerror=\"this.src='../img/iconodefault.jpg'\">";
                        echo "</button>"; 
                        echo "<div class='explorar__usuarios__info'><p class='nombre-usuario'>" . $usuario["username"] . "</p>
                            <p>@" . $usuario["username"] . "</p>
                        </div>";
                        echo "</div>";
                    }
                }
            ?>
        </div>
    </div>