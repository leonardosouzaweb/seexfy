<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../inc/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header('Location: ../login.php');
  exit;
}

$content = trim($_POST['content'] ?? '');
$image = '';

// Upload da imagem
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
  $image = 'uploads/' . uniqid() . '.' . $ext;
  move_uploaded_file($_FILES['image']['tmp_name'], '../' . $image);
}

// Salvar post
$stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $content, $image]);

header('Location: ../feed');
exit;