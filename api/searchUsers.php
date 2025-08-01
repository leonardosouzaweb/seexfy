<?php
header('Content-Type: application/json');
include_once '../inc/db.php';

$query = $_GET['q'] ?? '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

$stmt = $pdo->prepare("SELECT id, username, city, avatar FROM users WHERE username LIKE ? ORDER BY username ASC LIMIT 10");
$stmt->execute(["%$query%"]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($users);
