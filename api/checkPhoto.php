<?php
include '../api/db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['photo_id'])) {
    $photoId = $data['photo_id'];

    // Consulta ao banco de dados para verificar se a foto está oculta
    $sqlCheckHidden = "SELECT is_hidden FROM users_photos WHERE id = ?";
    $stmtCheckHidden = $conn->prepare($sqlCheckHidden);
    $stmtCheckHidden->bind_param("i", $photoId);
    $stmtCheckHidden->execute();
    $resultCheckHidden = $stmtCheckHidden->get_result();

    if ($resultCheckHidden->num_rows > 0) {
        $row = $resultCheckHidden->fetch_assoc();
        $isHidden = (bool)$row['is_hidden'];
        echo json_encode(['success' => true, 'isHidden' => $isHidden]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Photo not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
