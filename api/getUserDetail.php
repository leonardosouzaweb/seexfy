<?php
include_once '../api/db.php';

if(isset($_POST['id'])) {
    $userId = $_POST['id'];

    $sql = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $modal = '';
        if ($row["maritalStatus"] == "Solteiro" || $row["maritalStatus"] == "Solteira") {
            $modal = '../includes/singleModal.php'; 
        } elseif ($row["maritalStatus"] == "Casado" || $row["maritalStatus"] == "Casada") {
            $modal = '../includes/coupleModal.php';
        }
        if ($modal != '' && file_exists($modal)) {
            include_once $modal;
        } else {
            echo 'Modal não encontrada';
        }
    } else {
        echo 'Usuário não encontrado';
    }
} else {
    echo 'ID de usuário não fornecido';
}
?>
