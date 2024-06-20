<?php
// Inclui o arquivo de conexão com o banco de dados
include '../api/db.php';

// Recebe os dados do corpo da requisição JSON
$data = json_decode(file_get_contents("php://input"), true);

// Verifica se foi fornecido o photo_id
if (isset($data['photo_id'])) {
    $photoId = $data['photo_id'];

    // Atualiza o campo is_hidden para desocultar a foto
    $sqlUpdate = "UPDATE users_photos SET is_hidden = 0 WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("i", $photoId);

    // Executa a atualização
    if ($stmtUpdate->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to unhide photo']);
    }

} else {
    // Responde com erro se o photo_id não foi fornecido
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
