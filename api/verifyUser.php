<?php
if(isset($_FILES['filePhoto']) && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    $fileExtension = pathinfo($_FILES['filePhoto']['name'], PATHINFO_EXTENSION);
    if(!in_array($fileExtension, $allowedExtensions)) {
        echo "Erro: Apenas arquivos de imagem são permitidos (JPG, JPEG, PNG, GIF).";
        exit;
    }
    
    $uploadDirectory = '../assets/uploads/';
    
    $fileName = uniqid('photo_') . '.' . $fileExtension;
    
    $filePath = $uploadDirectory . $fileName;
    
    if(move_uploaded_file($_FILES['filePhoto']['tmp_name'], $filePath)) {
        include_once '../api/db.php';
        $sql = "INSERT INTO verification (user_id, filePhoto, photoVerification) VALUES (?, ?, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $filePath);
        if($stmt->execute()) {
            $sqlUpdate = "UPDATE users SET verification = 1 WHERE id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            $stmtUpdate->bind_param("i", $user_id);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            echo "Erro ao inserir os dados na tabela de verificação: " . $stmt->error;
        }
        $stmt->close();
        $conn->close();
    } else {
        echo "Erro ao fazer upload do arquivo.";
    }
} else {
    echo "Erro: Nenhum arquivo de foto enviado ou ID de usuário não recebido.";
}
?>
