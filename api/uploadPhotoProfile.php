<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../inc/db.php';

if (!isset($_SESSION['user_id'])) {
    die('Acesso negado.');
}

$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $uploadDir = '../uploads/gallery/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $photo = $_FILES['photo'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($photo['type'], $allowedTypes)) {
        die('Tipo de arquivo não permitido.');
    }

    if ($photo['size'] > $maxSize) {
        die('Arquivo muito grande. Máximo 5MB.');
    }

    $ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
    $filename = uniqid('profile_', true) . '.' . strtolower($ext);
    $destPath = $uploadDir . $filename;

    // Pegar nome do usuário para marca d'água
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    if (!$user) {
        die('Usuário não encontrado.');
    }
    $watermarkText = $user['username'];

    // Função que adiciona marca d'água repetida e comprime
    function addWatermarkRepeated($source, $destination, $text, $quality) {
        $info = getimagesize($source);
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

        // Cor branca com transparência alfa (0 = opaco, 127 = transparente)
        $white = imagecolorallocatealpha($image, 255, 255, 255, 100);

        // Fonte TTF - ajuste o caminho da fonte no seu servidor
        $fontPath = __DIR__ . '/arial.ttf';
        if (!file_exists($fontPath)) {
            imagedestroy($image);
            die("Fonte para marca d'água não encontrada.");
        }

        $fontSize = 15;
        $angle = 45;

        // Repetir texto diagonal pela imagem
        for ($x = -$width; $x < $width * 2; $x += 150) {
            for ($y = -$height; $y < $height * 2; $y += 150) {
                imagettftext($image, $fontSize, $angle, $x, $y, $white, $fontPath, $text);
            }
        }

        // Salvar imagem comprimida
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

    $quality = 75;

    // Processa imagem com marca d'água e compressão
    if (!addWatermarkRepeated($photo['tmp_name'], $destPath, $watermarkText, $quality)) {
        die('Erro ao processar a imagem.');
    }

    // Salva no banco
    $stmt = $pdo->prepare("INSERT INTO user_photos (user_id, filename) VALUES (?, ?)");
    $stmt->execute([$userId, $filename]);

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    die('Requisição inválida.');
}
