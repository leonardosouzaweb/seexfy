<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../inc/db.php';
session_start();
header('Content-Type: application/json');

// Define base_url manualmente
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $base_url = "http://localhost/seexfy";
} else {
    $base_url = "https://seexfy.com";
}

// Detecta localização com ipwho.is
$response = json_decode(file_get_contents("https://ipwho.is/"), true);

if (!$response['success']) {
    echo json_encode(['success' => false, 'error' => 'Erro ao obter localização por IP']);
    exit;
}

$lat = $response['latitude'];
$lon = $response['longitude'];
$city = $response['city'];
$userId = $_SESSION['user_id'] ?? null;

if (!$userId) {
    echo json_encode(['success' => false, 'error' => 'Usuário não autenticado']);
    exit;
}

// Atualiza localização do usuário
$stmt = $pdo->prepare("UPDATE users SET latitude = ?, longitude = ?, city = ? WHERE id = ?");
$stmt->execute([$lat, $lon, $city, $userId]);

// Busca usuários próximos (até 50 km), exceto o próprio
$stmt = $pdo->prepare("
    SELECT id, username, city, avatar, idade,
        (6371 * acos(
            cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
            sin(radians(?)) * sin(radians(latitude))
        )) AS distance
    FROM users
    WHERE id != ? AND latitude IS NOT NULL AND longitude IS NOT NULL
    HAVING distance < 50
    ORDER BY distance ASC
    LIMIT 12
");
$stmt->execute([$lat, $lon, $lat, $userId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajusta avatar para caminho absoluto
foreach ($users as &$u) {
    // Se avatar estiver vazio ou for o default relativo
    if (empty($u['avatar']) || $u['avatar'] === 'images/defaultAvatar.svg') {
        $u['avatar'] = $base_url . '/images/defaultAvatar.svg';
    }
    // Se não começar com http, montar caminho da pasta de uploads
    elseif (strpos($u['avatar'], 'http') !== 0) {
        $u['avatar'] = $base_url . '/uploads/avatars/' . $u['avatar'];
    }
}

echo json_encode([
    'success' => true,
    'users' => $users
]);
