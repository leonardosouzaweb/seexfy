<?php
$servername = "localhost";  // Nome do servidor MySQL
$username = "root";         // Nome de usuário do MySQL
$password = "root";             // Senha do MySQL
$dbname = "seexfy";         // Nome do banco de dados

// Crie a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifique a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
