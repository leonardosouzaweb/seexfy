<?php
session_start();
include_once '../api/db.php';

if (isset($_GET['receiver_id'])) {
    $receiver_id = $_GET['receiver_id'];

    $sqlMessages = "SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY sent_at ASC";
    $stmtMessages = $conn->prepare($sqlMessages);
    $stmtMessages->bind_param("iiii", $_SESSION['user_id'], $receiver_id, $receiver_id, $_SESSION['user_id']);
    $stmtMessages->execute();
    $resultMessages = $stmtMessages->get_result();
    $messages = $resultMessages->fetch_all(MYSQLI_ASSOC);

    foreach ($messages as $message) {
        $sent_time_formatted = date('H:i', strtotime($message['sent_at']));
        
        if ($message['sender_id'] == $_SESSION['user_id']) {
            echo '<div class="user1"><p>' . $message['message'] . ' <small>' . $sent_time_formatted . '</small></p></div>';
        } else {
            echo '<div class="user2"><p>' . $message['message'] . ' <small>' . $sent_time_formatted . '</small></p></div>';
        }
    }
} else {
    echo "receiver_id não definido na URL.";
}
?>
