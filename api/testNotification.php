<?php
include_once '../inc/db.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "Usuário não autenticado.";
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "Olá! Esta é uma notificação de teste inserida manualmente.2";

try {
    $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
    $stmt->execute([$user_id, $message]);
    echo "✅ Notificação inserida com sucesso.";
} catch (PDOException $e) {
    echo "Erro ao inserir notificação: " . $e->getMessage();
}
