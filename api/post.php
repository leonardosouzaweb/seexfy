<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once '../inc/db.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
  header('Location: ../login.php');
  exit;
}

$content = trim($_POST['content'] ?? '');
$imagePath = '';

// Busca nome do usuário para marca d’água
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
if (!$user) {
  die("Usuário não encontrado.");
}
$watermarkText = $user['username'];

// Função para adicionar marca d'água repetida
function addWatermarkRepeated($source, $destination, $text, $quality) {
    $info = getimagesize($source);
    if ($info === false) return false;
    $mime = $info['mime'];

    if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($mime == 'image/png') {
        $image = imagecreatefrompng($source);
    } elseif ($mime == 'image/webp') {
        $image = imagecreatefromwebp($source);
    } else {
        return false;
    }

    $width = imagesx($image);
    $height = imagesy($image);

    $alpha = 110; // Transparência da marca d'água (menor é mais opaco)
    $white = imagecolorallocatealpha($image, 255, 255, 255, $alpha);

    $fontPath = __DIR__ . '/../uploads/fonts/arial.ttf';
    if (!file_exists($fontPath)) {
        imagedestroy($image);
        die("Fonte para marca d'água não encontrada.");
    }

    $fontSize = 12;
    $angle = 0;

    $stepX = 80;
    $stepY = 50;

    for ($y = 0; $y < $height; $y += $stepY) {
        $offsetX = ($y / $stepY) % 2 == 0 ? 0 : intval($stepX / 2);
        for ($x = -$stepX; $x < $width + $stepX; $x += $stepX) {
            imagettftext($image, $fontSize, $angle, $x + $offsetX, $y + intval($fontSize * 1.2), $white, $fontPath, $text);
        }
    }

    if ($mime == 'image/jpeg' || $mime == 'image/jpg') {
        imagejpeg($image, $destination, $quality);
    } elseif ($mime == 'image/png') {
        $pngQuality = 9 - floor(($quality / 100) * 9);
        imagepng($image, $destination, $pngQuality);
    } elseif ($mime == 'image/webp') {
        imagewebp($image, $destination, $quality);
    }

    imagedestroy($image);
    return true;
}

// Upload da imagem com marca d’água
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $newFilename = uniqid() . '.' . strtolower($ext);
    $destPath = '../uploads/' . $newFilename;

    // Processa a imagem adicionando a marca d'água
    if (!addWatermarkRepeated($_FILES['image']['tmp_name'], $destPath, $watermarkText, 75)) {
        die("Erro ao processar a imagem.");
    }

    $imagePath = 'uploads/' . $newFilename;
}

// Salvar post no banco
$stmt = $pdo->prepare("INSERT INTO posts (user_id, content, image) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $content, $imagePath]);

header('Location: ../feed');
exit;
