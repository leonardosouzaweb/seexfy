<?php
session_start();
include_once '../api/db.php';

$response = ['success' => false];

if (isset($_FILES['avatar']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $fileTmpPath = $_FILES['avatar']['tmp_name'];
    $fileName = $_FILES['avatar']['name'];
    $fileSize = $_FILES['avatar']['size'];
    $fileType = $_FILES['avatar']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = '../assets/uploads/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;  // Gera um novo nome de arquivo usando uma hash
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $sqlUpdate = "UPDATE users SET avatar = ? WHERE id = ?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("si", $newFileName, $userId);  // Salva apenas o nome do arquivo no banco de dados
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['newAvatarPath'] = $newFileName;  // Retorna apenas o nome do arquivo
            } else {
                $response['error'] = 'Failed to update database.';
            }
            $stmt->close();
        } else {
            $response['error'] = 'Failed to move uploaded file.';
        }
    } else {
        $response['error'] = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }
} else {
    $response['error'] = 'No file uploaded or user not logged in.';
}

$conn->close();
echo json_encode($response);
?>
