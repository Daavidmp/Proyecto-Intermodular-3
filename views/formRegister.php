<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/register.css'>
</head>
<body>
    <div class="container">
    <div class="left">
        <img src="../img/login.png" alt="Imagen">
    </div>
    <div class="right">
        <div id="login">
            <form method="post" action="../controllers/register.php" class="login-form">
                <div class="logo">
                    <h1 class="titulo">MRTN</h1>
                    <img src="../img/corgi_logo.png" class="logo">
                </div>
                
                <p class="subtitulo">Hola por primera vez</p>

                <label for="username" class="form-label">Nuevo usuario</label>
                <input type="text" name="username" class="form-input"> 

                <label for="email" class="form-label">Nuevo correo</label>
                <input type="text" name="email" class="form-input">

                <label for="password" class="form-label">Nueva contraseña</label>
                <input type="password" name="password" class="form-input">

                <label for="nueva_password" class="form-label">Repetir nueva contraseña</label>
                <input type="password" name="nueva_password" class="form-input">
                <br><br>
                <button class="btn-gradient">Acceder</button>

                <p class="href-registrarse">¿Tienes ya una cuenta? <a style="color: purple" href="formLogin.php">Inicia sesión aquí</a></p>
            </form>

        </div>
    </div>
</div>

</body>
</html>