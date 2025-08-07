<?php
include_once '../inc/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("
        SELECT 
            n.id,
            n.message,
            n.created_at,
            u.username,
            u.avatar
        FROM notifications n
        LEFT JOIN users u ON n.sender_id = u.id
        WHERE n.user_id = ?
        ORDER BY n.created_at DESC
        LIMIT 30
    ");
    $stmt->execute([$user_id]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fallback caso sender_id seja NULL
    foreach ($notifications as &$noti) {
        if (!$noti['username']) $noti['username'] = 'Sistema';
        if (!$noti['avatar']) $noti['avatar'] = null;
    }

    echo json_encode($notifications);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar notificações: ' . $e->getMessage()]);
}
