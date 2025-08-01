<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include_once '../inc/db.php';

if (!isset($_SESSION['user_id']) || !isset($_FILES['avatar'])) {
    header('Location: ../profile');
    exit;
}

$user_id = $_SESSION['user_id'];

// Validar e mover o arquivo
$uploadDir = '../uploads/';
$filename = uniqid() . '_' . basename($_FILES['avatar']['name']);
$targetFile = $uploadDir . $filename;

$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$fileType = mime_content_type($_FILES['avatar']['tmp_name']);

if (!in_array($fileType, $allowedTypes)) {
    die('Formato inválido');
}

if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
    // Atualiza o avatar no banco
    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->execute([$filename, $user_id]);
}

header('Location: ../profile');
exit;
