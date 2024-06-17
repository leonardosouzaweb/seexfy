<?php
include '../api/db.php';

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['photo_id']) && isset($_SESSION['user_id'])) {
    $photoId = $data['photo_id'];
    $userId = $_SESSION['user_id'];

    // Verifica se o usuário já curtiu a foto
    $sqlCheckLiked = "SELECT COUNT(*) as liked FROM photo_likes WHERE photo_id = ? AND user_id = ?";
    $stmtCheckLiked = $conn->prepare($sqlCheckLiked);
    $stmtCheckLiked->bind_param("ii", $photoId, $userId);
    $stmtCheckLiked->execute();
    $resultCheckLiked = $stmtCheckLiked->get_result();
    $liked = $resultCheckLiked->fetch_assoc()['liked'];

    if ($liked == 0) {
        // Registra o like se o usuário ainda não curtiu a foto
        $sqlInsertLike = "INSERT INTO photo_likes (photo_id, user_id) VALUES (?, ?)";
        $stmtInsertLike = $conn->prepare($sqlInsertLike);
        $stmtInsertLike->bind_param("ii", $photoId, $userId);
        $stmtInsertLike->execute();

        if ($stmtInsertLike->affected_rows > 0) {
            // Atualiza o contador de likes na tabela users_photos
            $sqlUpdateLikes = "UPDATE users_photos SET likes = likes + 1 WHERE id = ?";
            $stmtUpdateLikes = $conn->prepare($sqlUpdateLikes);
            $stmtUpdateLikes->bind_param("i", $photoId);
            $stmtUpdateLikes->execute();

            echo json_encode(['success' => true, 'likes' => getLikesCount($conn, $photoId)]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao registrar o like']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário já curtiu esta foto']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}

function getLikesCount($conn, $photoId) {
    $sql = "SELECT likes FROM users_photos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $photoId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['likes'];
}
?>
