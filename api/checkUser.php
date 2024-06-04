<?php
include_once '../api/db.php';

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $sql = "SELECT COUNT(*) AS count FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        echo 'disponivel';
    } else {
        echo 'indisponivel';
    }
} else {
    echo 'Erro: Nenhum nome de usuário enviado.';
}
?>
