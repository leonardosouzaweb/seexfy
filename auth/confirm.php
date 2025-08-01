<?php
include_once '../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido');
}

$interests = !empty($_POST['interests']) 
  ? json_encode($_POST['interests'], JSON_UNESCAPED_UNICODE) 
  : json_encode([], JSON_UNESCAPED_UNICODE);

$maritalStatus = trim($_POST['maritalStatus'] ?? '');
$username      = trim($_POST['username'] ?? '');
$city          = trim($_POST['city'] ?? '');
$email         = trim($_POST['email'] ?? '');
$password      = $_POST['password'] ?? '';
$confirmPass   = $_POST['password_confirmation'] ?? '';

// validações
$errors = [];

if (empty($username)) {
    $errors[] = 'Nome de usuário é obrigatório.';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email inválido.';
}
if (strlen($password) < 8) {
    $errors[] = 'Senha precisa ter no mínimo 8 caracteres.';
}
if (!preg_match('/[A-Z]/', $password)) {
    $errors[] = 'Senha precisa ter ao menos uma letra maiúscula.';
}
if (!preg_match('/\W/', $password)) {
    $errors[] = 'Senha precisa ter ao menos um caractere especial.';
}
if ($password !== $confirmPass) {
    $errors[] = 'As senhas não coincidem.';
}

if ($errors) {
    http_response_code(422);
    echo implode('<br>', $errors);
    exit;
}

$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    // único email e username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
    $stmt->execute([':email' => $email, ':username' => $username]);
    if ($stmt->fetch()) {
        http_response_code(409);
        exit('Email ou usuário já cadastrado.');
    }

    $stmt = $pdo->prepare("
      INSERT INTO users 
        (interests, marital_status, username, city, email, password) 
      VALUES 
        (:interests, :marital, :username, :city, :email, :password)
    ");
    $stmt->execute([
      ':interests' => $interests,
      ':marital'   => $maritalStatus,
      ':username'  => $username,
      ':city'      => $city,
      ':email'     => $email,
      ':password'  => $hashed
    ]);

    header('Location: success.php');
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    exit('Erro interno: ' . $e->getMessage());
}
