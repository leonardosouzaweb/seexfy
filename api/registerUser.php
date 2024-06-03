<?php
include_once '../api/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 
    $city = $_POST['city'];
    $interests = $_POST['interests'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, city) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $city);
    
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;

        foreach ($interests as $interest) {
            $stmt = $conn->prepare("INSERT INTO user_interests (user_id, interest) VALUES (?, ?)");
            $stmt->bind_param("is", $user_id, $interest);
            $stmt->execute();
        }

        header("Location: register_success.php");
    } else {
        echo "Erro ao registrar usuário: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
