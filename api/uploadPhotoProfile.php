<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // <- ESSENCIAL
require_once '../inc/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acesso negado.');
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $uploadDir = '../uploads/gallery/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $photo = $_FILES['photo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($photo['type'], $allowedTypes)) {
        die('Tipo de arquivo não permitido.');
    }

    if ($photo['size'] > $maxSize) {
        die('Arquivo muito grande. Máximo 5MB.');
    }

    $ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
    $filename = uniqid('profile_', true) . '.' . $ext;

    if (move_uploaded_file($photo['tmp_name'], $uploadDir . $filename)) {
        $stmt = $pdo->prepare("INSERT INTO user_photos (user_id, filename) VALUES (?, ?)");
        $stmt->execute([$userId, $filename]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        die('Erro ao salvar o arquivo.');
    }
} else {
    die('Requisição inválida.');
}
