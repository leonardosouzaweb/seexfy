<?php
include_once '../api/db.php'; // Inclua seu arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Criptografe a senha
    $city = $_POST['city'];
    $interests = $_POST['interests'];

    // Insira o usuário na tabela users
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, city) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $city);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        // Insira os interesses do usuário na tabela user_interests
        foreach ($interests as $interest) {
            $stmt = $conn->prepare("INSERT INTO user_interests (user_id, interest) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $interest);
            $stmt->execute();
        }

        // Redireciona para a página de sucesso
        header("Location: register_success.php");
    } else {
        echo "Erro ao registrar usuário: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
