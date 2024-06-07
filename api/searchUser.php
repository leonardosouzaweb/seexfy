<?php
header('Content-Type: application/json');

include_once '../api/db.php';

try {
    if (!isset($_GET['query'])) {
        throw new Exception("Query parameter is missing");
    }

    $query = $_GET['query'];
    $sqlSearch = "SELECT username, age, maritalStatus, avatar FROM users WHERE username LIKE ?";
    $stmt = $conn->prepare($sqlSearch);
    if (!$stmt) {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }

    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
    if (!$stmt->execute()) {
        throw new Exception("Failed to execute statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }

    $stmt->close();
    $conn->close();

    echo json_encode($users);
} catch (Exception $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
