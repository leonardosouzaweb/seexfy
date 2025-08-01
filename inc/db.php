<?php
// Detecta automaticamente o ambiente baseado na URL
if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false) {
    // Ambiente Local
    $host = 'localhost';
    $db   = 'seexfy';
    $user = 'root';
    $pass = 'root';
} else {
    // Ambiente Produção
    $host = 'localhost';
    $db   = 'leona497_sex';
    $user = 'leona497_sex';
    $pass = 'Leo2248228@';
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
