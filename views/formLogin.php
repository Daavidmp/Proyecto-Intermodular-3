<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/login.css'>
</head>
<body>
    <div class="container">
    <div class="left">
        <img src="../img/login.png" alt="Imagen">
    </div>
    <div class="right">
        <div id="login">
            <form method="post" action="../controllers/login.php" class="login-form">
                <div class="logo">
                    <h1 class="titulo">MRTN</h1>
                    <img src="../img/corgi_logo.png" class="logo">
                </div>

                <p class="subtitulo">Bienvenido de nuevo</p>

                <label for="username" class="form-label">Usuario</label>
                <input type="text" name="username" class="form-input">

                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-input">

                <br><br>
                <button class="btn-gradient">Acceder</button>

                <p class="href-registrarse">¿No tienes cuenta? <a style="color: purple" href="formRegister.php">Regístrate aquí</a></p>
            </form>

        </div>
    </div>
</div>

</body>
</html>