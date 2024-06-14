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

    // Verifica se já existe uma entrada com os mesmos valores de latitude, longitude e endereço (desconsiderando a hora de criação)
    $sql_check = "SELECT COUNT(*) AS total FROM user_locations WHERE user_id = ? AND latitude = ? AND longitude = ? AND address = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("idds", $user_id, $latitude, $longitude, $address);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row = $result_check->fetch_assoc();

    if ($row['total'] > 0) {
        echo 'Essa localização já foi salva anteriormente.';
    } else {
        // Se não existir, insere os dados no banco
        $sql_insert = "INSERT INTO user_locations (user_id, latitude, longitude, address) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("idds", $user_id, $latitude, $longitude, $address);

        if ($stmt_insert->execute()) {
            echo 'Localização salva com sucesso!';
        } else {
            echo 'Erro ao salvar localização.';
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
    $conn->close();
} else {
    echo 'Parâmetros inválidos.';
}
?>
