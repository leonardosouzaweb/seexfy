<?php
include '../api/db.php';

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['photo_id']) && isset($_SESSION['user_id'])) {
    $photoId = $data['photo_id'];
    $userId = $_SESSION['user_id'];

    // Verifica se a foto pertence ao usuário
    $sqlCheckOwner = "SELECT id, is_hidden, is_public FROM users_photos WHERE id = ? AND user_id = ?";
    $stmtCheckOwner = $conn->prepare($sqlCheckOwner);
    $stmtCheckOwner->bind_param("ii", $photoId, $userId);
    $stmtCheckOwner->execute();
    $resultCheckOwner = $stmtCheckOwner->get_result();

    if ($resultCheckOwner->num_rows > 0) {
        $row = $resultCheckOwner->fetch_assoc();
        $newHiddenStatus = $row['is_hidden'] ? 0 : 1;

        // Atualiza o campo is_hidden e is_public na tabela users_photos
        $sqlToggleHide = "UPDATE users_photos SET is_hidden = ?, is_public = ? WHERE id = ?";
        $stmtToggleHide = $conn->prepare($sqlToggleHide);
        $isPublic = $newHiddenStatus ? 0 : 1; // Se estiver ocultando, não é público
        $stmtToggleHide->bind_param("iii", $newHiddenStatus, $isPublic, $photoId);
        $stmtToggleHide->execute();

        // Busca novamente as informações da foto após a atualização
        $stmtCheckOwner->execute();
        $row = $stmtCheckOwner->get_result()->fetch_assoc();

        echo json_encode(['success' => true, 'is_hidden' => $row['is_hidden'], 'is_public' => $row['is_public']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Unauthorized action']);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
