<?php
session_start();

include_once '../api/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message']) && isset($_POST['receiver_id'])) {
    $sender_id = $_SESSION['user_id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    // Insira a mensagem no banco de dados
    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $sender_id, $receiver_id, $message);
    if ($stmt->execute()) {
        // Envio bem-sucedido
        http_response_code(200);
        echo "Mensagem enviada com sucesso!";
    } else {
        // Erro ao enviar
        http_response_code(500);
        echo "Erro ao enviar a mensagem.";
    }
} else {
    // Requisição inválida
    http_response_code(400);
    echo "Requisição inválida.";
}
?>
