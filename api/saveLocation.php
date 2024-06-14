<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    exit('Usuário não autenticado');
}

include_once '../api/db.php';

if (isset($_POST['latitude'], $_POST['longitude'], $_POST['address'])) {
    $user_id = $_SESSION['user_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $address = $_POST['address'];

    // Query para inserir os dados no banco
    $sql = "INSERT INTO user_locations (user_id, latitude, longitude, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idds", $user_id, $latitude, $longitude, $address);
    
    if ($stmt->execute()) {
        echo 'Localização salva com sucesso!';
    } else {
        echo 'Erro ao salvar localização.';
    }

    $stmt->close();
    $conn->close();
} else {
    echo 'Parâmetros inválidos.';
}
?>
