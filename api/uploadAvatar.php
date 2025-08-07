<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
include_once '../inc/db.php';

if (!isset($_SESSION['user_id']) || !isset($_FILES['avatar'])) {
    header('Location: ../profile');
    exit;
}

$user_id = $_SESSION['user_id'];

// Diretório de upload: pasta avatars dentro de uploads
$uploadDir = '../uploads/avatars/';

// Garante que a pasta exista
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Tipos permitidos
$allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
$fileType = mime_content_type($_FILES['avatar']['tmp_name']);

if (!in_array($fileType, $allowedTypes)) {
    die('Formato inválido');
}

$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . strtolower($ext);
$targetFile = $uploadDir . $filename;

// Função para comprimir e salvar imagem otimizada
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);

    if ($info === false) {
        return false;
    }

    $mime = $info['mime'];

    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
            break;

        case 'image/png':
            $image = imagecreatefrompng($source);
            // Para PNG a qualidade é invertida (0-9)
            $pngQuality = 9 - floor(($quality / 100) * 9);
            imagepng($image, $destination, $pngQuality);
            break;

        case 'image/webp':
            $image = imagecreatefromwebp($source);
            imagewebp($image, $destination, $quality);
            break;

        default:
            return false;
    }

    imagedestroy($image);
    return true;
}

$quality = 75; // qualidade de compressão (%)

// Comprimir e salvar no destino
if (compressImage($_FILES['avatar']['tmp_name'], $targetFile, $quality)) {
    // Atualiza o avatar no banco
    // Salvamos só o nome do arquivo, para construir o caminho na exibição
    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->execute([$filename, $user_id]);
} else {
    die('Erro ao processar a imagem.');
}

// Busca o username para redirecionar
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$username = $stmt->fetchColumn();

header('Location: ../profile/' . rawurlencode($username));
exit;
