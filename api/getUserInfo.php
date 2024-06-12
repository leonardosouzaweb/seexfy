<?php
include_once '../api/db.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sqlUser = "SELECT username, avatar, maritalStatus FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    header('Content-Type: application/json');
    echo json_encode($user);
} else {
    echo json_encode(array('error' => 'ID not provided'));
}
?>
