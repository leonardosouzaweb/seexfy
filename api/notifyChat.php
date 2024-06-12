<?php
session_start();
include_once '../api/db.php';

// Verificar se há novas interações não visualizadas para o usuário
$sql = "SELECT COUNT(*) AS new_interactions FROM interactions WHERE interacted_user_id = ? AND id NOT IN (SELECT interaction_id FROM messages)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$newInteractions = ($row['new_interactions'] > 0) ? true : false;

echo json_encode(['newInteractions' => $newInteractions]);
?>
