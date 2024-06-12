<?php
include_once '../config/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];

// Obter o ID do usuário que está sendo interagido
$sqlUserId = "SELECT id FROM users WHERE username = ?";
$stmtUserId = $conn->prepare($sqlUserId);
$stmtUserId->bind_param("s", $username);
$stmtUserId->execute();
$resultUserId = $stmtUserId->get_result();
$interactedUser = $resultUserId->fetch_assoc();

if ($interactedUser) {
    $userId = $_SESSION['user_id'];
    $interactedUserId = $interactedUser['id'];

    // Verificar se a interação já existe
    $sqlCheckInteraction = "SELECT id FROM interactions WHERE user_id = ? AND interacted_user_id = ?";
    $stmtCheckInteraction = $conn->prepare($sqlCheckInteraction);
    $stmtCheckInteraction->bind_param("ii", $userId, $interactedUserId);
    $stmtCheckInteraction->execute();
    $resultCheckInteraction = $stmtCheckInteraction->get_result();

    if ($resultCheckInteraction->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Interação já existe']);
        exit();
    }

    // Adicionar interação ao banco de dados
    $sqlInsert = "INSERT INTO interactions (user_id, interacted_user_id) VALUES (?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ii", $userId, $interactedUserId);
    if ($stmtInsert->execute()) {
        echo json_encode(['success' => true, 'message' => 'Interação adicionada com sucesso']);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao adicionar interação']);
    }
    $stmtInsert->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Usuário não encontrado']);
}

$stmtUserId->close();
$stmtCheckInteraction->close();
$conn->close();
?>
