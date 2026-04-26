<?php 
    require_once "../controllers/mensajes.php";
    date_default_timezone_set('Europe/Madrid');
    
    $usuario_actual = $_SESSION["username"];
    $emisor_id      = $_SESSION["id"];
    $receptor_id    = $_GET['receptor_id'];

    $mensajes      = mostrarMensajesEntreUsuarios($conexion, $emisor_id, $receptor_id);
    $receptor_info = obtenerUsuarioPorId($conexion, $receptor_id);
?>
    <div class="chat-container">
        <div class="chat-header">
            <img src="<?php echo $receptor_info['avatar_url']; ?>" class="avatar">
            <h2><?php echo $receptor_info['username']; ?></h2>
        </div>

        <div class="chat-messages" id="chat-messages">
            <?php foreach($mensajes as $mensaje): ?>
                <div class="message <?php echo $mensaje['emisor_id'] == $emisor_id ? 'sent' : 'received'; ?>">
                    <p><?php echo htmlspecialchars($mensaje['contenido']); ?></p>
                    <span class="time"><?php echo date('H:i', strtotime($mensaje['fecha_envio'])); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="chat-input">
            <input type="text" id="contenido_msg" placeholder="Escribe un mensaje..." autocomplete="off">
            <button type="button" id="btn_enviar_msg">Enviar</button>
        </div>
    </div>

<script>
    // Sin $(document).ready() — el DOM ya existe cuando la SPA inyecta este script
    (function() {
        var receptorId = <?php echo json_encode($receptor_id); ?>;

        // Scroll al fondo
        var chatMessages = document.getElementById('chat-messages');
        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;

        function enviarMensaje() {
            var input = document.getElementById('contenido_msg');
            var contenido = input.value.trim();
            if (!contenido) return;
            input.value = '';

            fetch('/controllers/enviarMensaje.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'receptor_id=' + encodeURIComponent(receptorId) + '&contenido=' + encodeURIComponent(contenido)
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    loadSection('ViewChat.php?receptor_id=' + receptorId);
                } else {
                    alert('Error: ' + (data.error || 'desconocido'));
                }
            })
            .catch(function(err) {
                console.error('Error:', err);
                alert('Error de conexión.');
            });
        }

        document.getElementById('btn_enviar_msg').addEventListener('click', enviarMensaje);
        document.getElementById('contenido_msg').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') enviarMensaje();
        });
    })();
</script>