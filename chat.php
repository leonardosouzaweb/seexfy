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
                <div class="chatContainer">
                    <?php include_once 'includes/chat.php'; ?>
                </div>
            </div>
            <?php include_once 'includes/bottomMenu.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            
            function iniciarInteracao(username, receiverId) {
                var chatHeader = document.querySelector('.chatHeader');
                chatHeader.innerHTML = `
                    <img src="<?php echo $base_url; ?>assets/uploads/defaultAvatar.svg">
                    <p>${username} <small>Solteiro / Offline</small></p>
                `;
                document.querySelector('.chatList').style.display = 'none';
                document.querySelector('.chat').style.display = 'block';

                document.getElementById('receiverId').value = receiverId;

                carregarMensagens();
            }

            var profileLinks = document.querySelectorAll('.navGoUser');
            profileLinks.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    var username = link.dataset.username;
                    var receiverId = link.dataset.userid;
                    iniciarInteracao(username, receiverId);
                });
            });

            document.getElementById('messageForm').addEventListener('submit', function(event) {
                event.preventDefault();
                var messageInput = document.getElementById('messageInput').value;
                var receiverId = document.getElementById('receiverId').value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'api/messages.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        document.getElementById('messageInput').value = '';
                        carregarMensagens();
                    }
                };
                xhr.send('message=' + encodeURIComponent(messageInput) + '&receiver_id=' + encodeURIComponent(receiverId));
            });

            function carregarMensagens() {
                var receiverId = document.getElementById('receiverId').value;

                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'api/loadMessages.php?receiver_id=' + encodeURIComponent(receiverId), true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        console.log("Mensagens carregadas com sucesso!");
                        document.querySelector('.chatMessage').innerHTML = xhr.responseText;
                        // setTimeout(carregarMensagens, 3000);
                    } else {
                        console.log("Erro ao carregar mensagens. Status: " + xhr.status);
                        // Tentar novamente após 5 segundos em caso de erro
                        setTimeout(carregarMensagens, 5000);
                    }
                };
                xhr.onerror = function() {
                    console.log("Erro de rede ao tentar carregar mensagens.");
                    // Tentar novamente após 5 segundos em caso de erro de rede
                    setTimeout(carregarMensagens, 5000);
                };
                xhr.send();
            }

            // Inicia o carregamento das mensagens assim que a página é carregada
            carregarMensagens();

            function adjustWrapperHeight() {
                const wrapper = document.querySelector('.home .wrapper');
                const topMenuHeight = document.querySelector('.home .topMenu').offsetHeight;
                const bottomMenuHeight = document.querySelector('.home .bottomMenu').offsetHeight;
                const viewportHeight = window.innerHeight;

                wrapper.style.height = `${viewportHeight - topMenuHeight - bottomMenuHeight}px`;
                }

                // Ajustar a altura ao carregar a página e ao redimensionar a janela
                window.addEventListener('load', adjustWrapperHeight);
            });
    </script>
</body>
</html>
