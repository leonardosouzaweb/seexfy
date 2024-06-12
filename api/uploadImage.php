<?php
session_start();
include_once '../api/db.php';

$response = array();

if (isset($_FILES['photos']['name'])) {
    $user_id = $_SESSION['user_id'];

    // Diretório de upload específico para o usuário
    $uploadDir = '../assets/uploads/gallery/'.$user_id.'/';

    // Verifica se o diretório existe, se não, cria
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Cria o diretório recursivamente
    }

    // Loop através de cada arquivo
    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $photo_name = $_FILES['photos']['name'][$key];
        $photo_tmp_name = $_FILES['photos']['tmp_name'][$key];
        $photo_path = $uploadDir . $photo_name;

        // Move o arquivo enviado para o destino
        if (move_uploaded_file($photo_tmp_name, $photo_path)) {
            // Salva o caminho da foto no banco de dados
            $sql = "INSERT INTO users_photos (user_id, photo_path) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $photo_path);
            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['error'] = "Erro ao salvar a foto no banco de dados.";
            }
        } else {
            $response['error'] = "Erro ao fazer upload da foto.";
        }
    }

    // Atualiza a galeria de fotos após o upload
    $sqlPhotos = "SELECT photo_path FROM users_photos WHERE user_id = ?";
    $stmtPhotos = $conn->prepare($sqlPhotos);
    $stmtPhotos->bind_param("i", $user_id);
    $stmtPhotos->execute();
    $resultPhotos = $stmtPhotos->get_result();

    ob_start();
    while ($photo = $resultPhotos->fetch_assoc()) {
        echo '<div class="photo-item"><img src="' . $photo['photo_path'] . '" alt="User Photo"></div>';
    }
    $response['photosHTML'] = ob_get_clean();
} else {
    $response['error'] = "Nenhuma foto selecionada.";
}

header('Content-Type: application/json');
echo json_encode($response);
?>
