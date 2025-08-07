<?php
include_once '../inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  exit('Usuário não autenticado');
}

$notification_id = $_POST['id'] ?? null;

if (!$notification_id) {
  http_response_code(400);
  exit('ID inválido');
}

$stmt = $pdo->prepare("DELETE FROM notifications WHERE id = ? AND user_id = ?");
$stmt->execute([$notification_id, $_SESSION['user_id']]);

echo json_encode(['success' => true]);
