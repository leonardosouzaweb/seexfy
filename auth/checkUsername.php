<?php
include_once '../inc/db.php';

header('Content-Type: application/json');

if (!isset($_GET['username'])) {
    echo json_encode(['error' => 'Parâmetro username é obrigatório']);
    exit;
}

$username = trim($_GET['username']);

try {
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);

    echo json_encode(['available' => !$stmt->fetch()]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erro no banco de dados']);
}
?>
