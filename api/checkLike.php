<?php
include '../api/db.php';

session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['photo_id']) && isset($_SESSION['user_id'])) {
    $photoId = $data['photo_id'];
    $userId = $_SESSION['user_id'];

    // Verifica se o usuário já curtiu a foto
    $sqlCheckLiked = "SELECT COUNT(*) as liked FROM likes WHERE photo_id = ? AND user_id = ?";
    $stmtCheckLiked = $conn->prepare($sqlCheckLiked);
    $stmtCheckLiked->bind_param("ii", $photoId, $userId);
    $stmtCheckLiked->execute();
    $resultCheckLiked = $stmtCheckLiked->get_result();

    if ($resultCheckLiked->num_rows > 0) {
        $row = $resultCheckLiked->fetch_assoc();
        $liked = $row['liked'] > 0 ? true : false;
        echo json_encode(['success' => true, 'liked' => $liked]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
