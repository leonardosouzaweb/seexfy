<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../inc/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  http_response_code(401);
  exit;
}

$post_id = $_POST['post_id'] ?? null;
$emoji_key = $_POST['emoji'] ?? null;

$emoji_map = [
  'fogo' => '🔥',
  'diabinho' => '😈',
  'surpreso' => '😮',
  'safado' => '😏',
  'aplausos' => '👏',
  'coração' => '❤️'
];

if (!$post_id || !array_key_exists($emoji_key, $emoji_map)) {
  http_response_code(400);
  exit;
}

try {
  // 1. Inserir ou atualizar a reação
  $stmt = $pdo->prepare("INSERT INTO post_reactions (post_id, user_id, emoji_key)
                         VALUES (?, ?, ?)
                         ON DUPLICATE KEY UPDATE emoji_key = VALUES(emoji_key)");
  $stmt->execute([$post_id, $user_id, $emoji_key]);

  // 2. Buscar dono do post para enviar notificação
  $stmtPost = $pdo->prepare("SELECT user_id FROM posts WHERE id = ?");
  $stmtPost->execute([$post_id]);
  $postOwnerId = $stmtPost->fetchColumn();

  // Evitar notificação se o usuário reagiu ao próprio post
  if ($postOwnerId && $postOwnerId != $user_id) {
    $emoji = $emoji_map[$emoji_key];
    $message = "Seu post recebeu uma reação";

    $stmtNotif = $pdo->prepare("
      INSERT INTO notifications (user_id, sender_id, message, post_id)
      VALUES (?, ?, ?, ?)
    ");
    $stmtNotif->execute([
      $postOwnerId,   // quem deve receber a notificação
      $user_id,       // quem enviou
      $message,
      $post_id
    ]);
  }

  http_response_code(200);

} catch (PDOException $e) {
  http_response_code(500);
  echo "Erro: " . $e->getMessage();
}
