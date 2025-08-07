<?php
session_start();
include_once '../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: login.php');
  exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
  $_SESSION['login_error'] = 'E-mail ou senha inválidos.';
  header('Location: login.php');
  exit;
}

try {
  $stmt = $pdo->prepare("SELECT id, password, username FROM users WHERE email = :email LIMIT 1");
  $stmt->execute(['email' => $email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['login_error'] = 'E-mail ou senha incorretos.';
    header('Location: login.php');
    exit;
  }

  // Autenticado
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['username'] = $user['username'];

  header('Location: ../home');
  exit;
} catch (PDOException $e) {
  $_SESSION['login_error'] = 'Erro interno, tente novamente.';
  header('Location: login.php');
  exit;
}
