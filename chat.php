<?php include_once 'includes/head.php'; ?>

<body>
    <div class="empty">
        <img src="assets/images/logo.svg">
    </div>
    <div class="home">
        <div class="wrapper">
            <?php include_once 'includes/topMenu.php'; ?>
            <div class="content">
                <h1>Chat</h1>
                <div class="chat-container">
                    <div class="message" onclick="showChat()">Mensagem de Chat</div>
                    <div class="chat" id="chat" style="display: none;">
                        <!-- Conteúdo do Chat -->
                        <div class="chat-message">Olá! Esta é uma mensagem de chat.</div>
                        <div class="chat-message">Como posso ajudá-lo?</div>
                    </div>
                </div>
            </div>
            <?php include_once 'includes/bottomMenu.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        function showChat() {
            var chat = document.getElementById('chat');
            if (chat.style.display === 'none') {
                chat.style.display = 'block';
            } else {
                chat.style.display = 'none';
            }
        }
    </script>
</body>
</html>
