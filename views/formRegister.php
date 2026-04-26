<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro · MRTN</title>
    <link rel="stylesheet" href="/css/register.css">
</head>
<body class="auth-page">
    <div class="container">
        <div class="left">
            <img src="/img/login.png" alt="Imagen">
        </div>
        <div class="right">
            <div id="login">
                <form class="login-form" id="registerForm" novalidate>
                    <div class="logo">
                        <h1 class="titulo">MRTN</h1>
                        <img src="/img/corgi_logo.png" class="logo" alt="logo">
                    </div>

                    <p class="subtitulo">Hola por primera vez</p>

                    <!-- Caja de error/éxito -->
                    <div class="form-alert" id="formAlert" style="display:none;"></div>

                    <label class="form-label" for="username">Nuevo usuario</label>
                    <input type="text" id="username" name="username" class="form-input" autocomplete="username">

                    <label class="form-label" for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-input" autocomplete="email">

                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input" autocomplete="new-password">

                    <label class="form-label" for="nueva_password">Repetir contraseña</label>
                    <input type="password" id="nueva_password" name="nueva_password" class="form-input" autocomplete="new-password">

                    <br><br>
                    <button class="btn-gradient" id="submitBtn" type="submit">Crear cuenta</button>

                    <p class="href-registrarse">¿Ya tienes cuenta? <a style="color:purple" href="formLogin.php">Inicia sesión aquí</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
    (function () {
        var form      = document.getElementById('registerForm');
        var alertBox  = document.getElementById('formAlert');
        var submitBtn = document.getElementById('submitBtn');

        function showAlert(msg, type) {
            alertBox.textContent   = msg;
            alertBox.className     = 'form-alert form-alert--' + type;
            alertBox.style.display = 'block';
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            alertBox.style.display = 'none';

            var username      = document.getElementById('username').value.trim();
            var email         = document.getElementById('email').value.trim();
            var password      = document.getElementById('password').value;
            var nueva_password = document.getElementById('nueva_password').value;

            // Validación client-side rápida
            if (!username || !email || !password || !nueva_password) {
                showAlert('Rellena todos los campos.', 'error');
                return;
            }
            if (password !== nueva_password) {
                showAlert('Las contraseñas no coinciden.', 'error');
                return;
            }
            if (password.length < 6) {
                showAlert('La contraseña debe tener al menos 6 caracteres.', 'error');
                return;
            }

            submitBtn.disabled    = true;
            submitBtn.textContent = 'Creando cuenta...';

            fetch('/controllers/register.php', {
                method:  'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: [
                    'username='      + encodeURIComponent(username),
                    'email='         + encodeURIComponent(email),
                    'password='      + encodeURIComponent(password),
                    'nueva_password=' + encodeURIComponent(nueva_password)
                ].join('&')
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    showAlert(data.message || '¡Cuenta creada! Redirigiendo...', 'success');
                    form.reset();
                    setTimeout(function () { window.location.href = data.redirect; }, 1200);
                } else {
                    showAlert(data.message || 'Error al crear la cuenta.', 'error');
                    submitBtn.disabled    = false;
                    submitBtn.textContent = 'Crear cuenta';
                }
            })
            .catch(function () {
                showAlert('Error de conexión. Inténtalo de nuevo.', 'error');
                submitBtn.disabled    = false;
                submitBtn.textContent = 'Crear cuenta';
            });
        });
    })();
    </script>
</body>
</html>