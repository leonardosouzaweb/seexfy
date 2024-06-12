<?php
    $sqlInteractions = "SELECT u.id, u.username, u.maritalStatus, u.avatar FROM interactions i JOIN users u ON i.interacted_user_id = u.id WHERE i.user_id = ?";
    $stmtInteractions = $conn->prepare($sqlInteractions);
    $stmtInteractions->bind_param("i", $user_id);
    $stmtInteractions->execute();
    $resultInteractions = $stmtInteractions->get_result();
    $interactions = $resultInteractions->fetch_all(MYSQLI_ASSOC);

    // Buscar as mensagens trocadas entre os usuários
    $sqlMessages = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at ASC";
    $stmtMessages = $conn->prepare($sqlMessages);
    $stmtMessages->bind_param("iiii", $_SESSION['user_id'], $receiver_id, $receiver_id, $_SESSION['user_id']);
    $stmtMessages->execute();
    $resultMessages = $stmtMessages->get_result();
    $messages = $resultMessages->fetch_all(MYSQLI_ASSOC);
?>
<div class="chatList">
<?php foreach ($interactions as $interaction): ?>
    <div class="listUser">
        <div>
            <div class="listAvatar">
                <img src="<?php echo $base_url; ?>assets/uploads/users/<?php echo $interaction['username']; ?><?php echo $interaction['avatar']; ?>">
            </div>
            <div class="listInfo">
                <span><?php echo $interaction['username']; ?> <small><?php echo $interaction['maritalStatus']; ?></small></span>
            </div>
        </div>
        <a href="#" class="navGoUser" data-username="<?php echo $interaction['username']; ?>" data-userid="<?php echo $interaction['id']; ?>">
            <img src="<?php echo $base_url; ?>assets/images/icons/iconNavProfile.svg">
        </a>
    </div>
<?php endforeach; ?>
</div>

<div class="chat">
    <div class="chatHeader"></div>
    <div class="chatMessage"></div>
    <div class="sendMessage">
        <form id="messageForm">
            <input type="hidden" id="receiverId" value="">
            <input type="text" id="messageInput" class="form-control" placeholder="Digite sua mensagem">
            <button type="submit">Enviar</button>
        </form>
    </div>
</div>
