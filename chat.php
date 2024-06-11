<?php
    include_once 'includes/head.php';
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./entrar");
        exit(); 
    }

    include_once 'config/db.php';

    $user_id = $_SESSION['user_id'];
    $sqlUser = "SELECT maritalStatus, username, avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $conn->close();
?>

<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <div class="home">
        <div class="wrapper">
            <?php include_once 'includes/topMenu.php'; ?>
            <div class="content">
                <h1>Chat</h1>
                <?php include_once 'includes/chat.php'; ?>
            </div>
            <?php include_once 'includes/bottomMenu.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var startChatBtn = document.getElementById('startChat');
            var chatList = document.querySelector('.chatList');
            var chat = document.querySelector('.chat');

            startChatBtn.addEventListener('click', function(event) {
                event.preventDefault();

                chatList.style.display = 'none';
                chat.style.display = 'block';
            });

            // Função para adicionar evento de clique nas divs user1 e user2
        function addReactionDisplayEvent() {
            var user1 = document.querySelector('.user1');
            var user2 = document.querySelector('.user2');

            // Adiciona evento de clique na div user1
            user1.addEventListener('click', function() {
                var reactions = this.querySelector('.reactions');
                reactions.style.display = "block";
            });

            // Adiciona evento de clique na div user2
            user2.addEventListener('click', function() {
                var reactions = this.querySelector('.reactions');
                reactions.style.display = "block";
            });
        }

        // Função para adicionar evento de clique nas reações
        function addReactionClickEvent() {
            var reactionButtons = document.querySelectorAll('.reactions button');

            reactionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Esconde todas as reações
                    var allReactions = document.querySelectorAll('.reactions');
                    allReactions.forEach(function(reaction) {
                        reaction.style.display = "none";
                    });

                    // Remove a classe 'selected' de todas as reações
                    reactionButtons.forEach(function(btn) {
                        btn.classList.remove('selected');
                    });

                    // Adiciona a classe 'selected' apenas à reação clicada
                    this.classList.add('selected');
                });
            });
        }

        // Chama a função para adicionar os eventos quando o DOM estiver carregado
        addReactionDisplayEvent();
        addReactionClickEvent();
        });
    </script>
</body>
</html>
