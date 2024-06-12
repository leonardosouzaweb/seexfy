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
    <?php include_once 'includes/topMenu.php'; ?>
    <div class="home">
        <div class="wrapper">
            
            <div class="content">
                <h2>Chat</h2>
                <div class="chatContainer">
                    <?php include_once 'includes/chat.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function iniciarInteracao(username, receiverId) {
                console.log("Receiver ID:", receiverId);

                var chatHeader = document.querySelector('.chatHeader');

                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'api/getUserInfo.php?id=' + receiverId, true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var userData = JSON.parse(xhr.responseText);
                        console.log("UserData:", userData); 
                        var receiverAvatar = userData.avatar;

                        var avatarUrl = "<?php echo $base_url; ?>assets/uploads/users/" + username + "/" + receiverAvatar;
                        chatHeader.innerHTML = `
                            <img src="${avatarUrl}">
                            <p>${username} <small>Solteiro / Offline</small></p>
                        `;

                        document.querySelector('.chatList').style.display = 'none';
                        document.querySelector('.chat').style.display = 'block';

                        document.getElementById('receiverId').value = receiverId;
                        carregarMensagens();
                    } else {
                        console.log("Erro ao buscar informações do usuário. Status: " + xhr.status);
                    }
                };
                xhr.send();
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
                        if (/Mobi|Android/i.test(navigator.userAgent)) {
                            document.activeElement.blur();
                        }
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
                        setTimeout(carregarMensagens, 5000);
                    }
                };
                xhr.onerror = function() {
                    console.log("Erro de rede ao tentar carregar mensagens.");
                    setTimeout(carregarMensagens, 5000);
                };
                xhr.send();
            }

            carregarMensagens();
        });
    </script>
</body>
</html>
