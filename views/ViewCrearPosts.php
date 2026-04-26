    <div class="form-container">
        <form action="../controllers/post.php" method="post">
            <h1 class="form__titulo">Crear Nuevo Post</h1>
            
            <label for="contenido" class="form__label">Contenido del post</label>
            <textarea name="contenido" id="contenido" class="form__input" placeholder="Escribe el contenido de tu post..."></textarea>

            <label for="image_link" class="form__label">Imagen</label>
            <input type="text" name="image_link" class="form__input">

            <label for="music_link" class="form__label">Link a la canción</label>
            <input type="text" name="music_link" id="music_link" class="form__input" placeholder="Pega el enlace de la canción...">
            
            <button id="btn_posts">Crear Post</button>
        </form>
    </div>