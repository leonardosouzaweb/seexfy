<?php
include_once '../inc/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  http_response_code(401);
  echo json_encode(['error' => 'Não autenticado']);
  exit;
}

$userId = $_SESSION['user_id'];
$data = $_POST;

// Sanitizar e validar os dados conforme necessário
$fields = [
  'idade', 'orientacao', 'signo', 'altura', 'fuma', 'bebe', 'experiencia'
];

$placeholders = [];
$values = [];

foreach ($fields as $field) {
  $placeholders[] = "$field = ?";
  $values[] = trim($data[$field] ?? null);
}

$interests = json_encode($data['interests'] ?? []);
$placeholders[] = "interests = ?";
$values[] = $interests;

$values[] = $userId;

// Verificar se já existe registro
$stmt = $pdo->prepare("SELECT id FROM partner_profiles WHERE user_id = ?");
$stmt->execute([$userId]);

if ($stmt->fetch()) {
  $sql = "UPDATE partner_profiles SET " . implode(', ', $placeholders) . " WHERE user_id = ?";
} else {
  $sql = "INSERT INTO partner_profiles (" . implode(', ', $fields) . ", interests, user_id) VALUES (" . rtrim(str_repeat("?, ", count($fields) + 2), ', ') . ")";
}

$stmt = $pdo->prepare($sql);
$stmt->execute($values);

echo json_encode(['success' => true]);
