<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · MRTN</title>
    <link rel="stylesheet" href="/css/login.css">
</head>
<body class="auth-page">
    <div class="container">
        <div class="left">
            <img src="/img/login.png" alt="Imagen">
        </div>
        <div class="right">
            <div id="login">
                <form class="login-form" id="loginForm" novalidate>
                    <div class="logo">
                        <h1 class="titulo">MRTN</h1>
                        <img src="/img/corgi_logo.png" class="logo" alt="logo">
                    </div>

                    <p class="subtitulo">Bienvenido de nuevo</p>

                    <!-- Caja de error/éxito -->
                    <div class="form-alert" id="formAlert" style="display:none;"></div>

                    <label class="form-label" for="username">Usuario</label>
                    <input type="text" id="username" name="username" class="form-input" autocomplete="username">

                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" autocomplete="current-password">

                    <br><br>
                    <button class="btn-gradient" id="submitBtn" type="submit">Acceder</button>

                    <p class="href-registrarse">¿No tienes cuenta? <a style="color:purple" href="formRegister.php">Regístrate aquí</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
    (function () {
        var form      = document.getElementById('loginForm');
        var alert     = document.getElementById('formAlert');
        var submitBtn = document.getElementById('submitBtn');

        function showAlert(msg, type) {
            alert.textContent  = msg;
            alert.className    = 'form-alert form-alert--' + type;
            alert.style.display = 'block';
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            alert.style.display = 'none';

            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value;

            if (!username || !password) {
                showAlert('Rellena todos los campos.', 'error');
                return;
            }

            submitBtn.disabled    = true;
            submitBtn.textContent = 'Accediendo...';

            fetch('/controllers/login.php', {
                method:  'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body:    'username=' + encodeURIComponent(username) + '&password=' + encodeURIComponent(password)
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    showAlert('¡Bienvenido! Redirigiendo...', 'success');
                    setTimeout(function () { window.location.href = data.redirect; }, 600);
                } else {
                    showAlert(data.message || 'Error al iniciar sesión.', 'error');
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Acceder';
                }
            })
            .catch(function () {
                showAlert('Error de conexión. Inténtalo de nuevo.', 'error');
                submitBtn.disabled    = false;
                submitBtn.textContent = 'Acceder';
            });
        });
    })();
    </script>
</body>
</html>