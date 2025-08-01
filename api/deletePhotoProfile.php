<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // <- ESSENCIAL
require_once '../inc/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acesso negado.');
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['photo_id'])) {
    $photoId = intval($_POST['photo_id']);

    // Buscar o nome do arquivo
    $stmt = $pdo->prepare("SELECT filename FROM user_photos WHERE id = ? AND user_id = ?");
    $stmt->execute([$photoId, $userId]);
    $photo = $stmt->fetch();

    if ($photo) {
        $filePath = '../uploads/gallery/' . $photo['filename'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Remover do banco
        $stmt = $pdo->prepare("DELETE FROM user_photos WHERE id = ? AND user_id = ?");
        $stmt->execute([$photoId, $userId]);

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        die('Foto não encontrada ou permissão negada.');
    }
} else {
    die('Requisição inválida.');
}
