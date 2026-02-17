<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Pagina principal</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='./css/index.css'>
    <script src='main.js'></script>
</head>
<body>
    <div class="title-wrapper">
        <img src="./img/corgi_logo.png" class="logo">
        <h1 class="title">mrtn</h1>
    </div>

    <p class="subtitle">La música también se conversa.</p>

    <div class="button">
        <button id="start" class="btn-gradient">Comenzar</button>
    </div>
    <div class="pointer">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#1f1f1f"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const button = document.getElementById("start");

        button.addEventListener("click", () => {
            window.location.href = "./views/formLogin.php";
        });
    })
</script>
</html>