<?php
session_start();
include_once '../api/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Usuário não autenticado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Validar a entrada
    if (is_numeric($latitude) && is_numeric($longitude)) {
        $sql = "INSERT INTO user_locations (user_id, latitude, longitude) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("idd", $user_id, $latitude, $longitude);
            if ($stmt->execute()) {
                echo json_encode(['success' => 'Localização salva com sucesso']);
            } else {
                echo json_encode(['error' => 'Erro ao salvar a localização']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => 'Erro ao preparar a declaração']);
        }
    } else {
        echo json_encode(['error' => 'Dados de localização inválidos']);
    }
    $conn->close();
} else {
    echo json_encode(['error' => 'Método de solicitação inválido']);
}
?>
