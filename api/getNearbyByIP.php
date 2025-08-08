<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../inc/db.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $base_url = "http://localhost/seexfy";
} else {
    $base_url = "https://seexfy.com";
}

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

if (!is_numeric($lat) || !is_numeric($lon)) {
    echo json_encode(['success' => false, 'error' => 'Coordenadas inválidas']);
    exit;
}

$stmt = $pdo->prepare("UPDATE users SET latitude = ?, longitude = ?, city = ? WHERE id = ?");
$stmt->execute([$lat, $lon, $city, $userId]);

// Calcula distância em metros
$stmt = $pdo->prepare("
    SELECT id, username, city, avatar, idade,
      (6371000 * 2 * ASIN(SQRT(
        POWER(SIN(RADIANS(latitude - ?) / 2), 2) +
        COS(RADIANS(?)) * COS(RADIANS(latitude)) *
        POWER(SIN(RADIANS(longitude - ?) / 2), 2)
      ))) AS distance
    FROM users
    WHERE id != ? AND latitude IS NOT NULL AND longitude IS NOT NULL
    HAVING distance < 50000 -- até 50 km
    ORDER BY distance ASC
    LIMIT 12
");
$stmt->execute([$lat, $lat, $lon, $userId]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as &$u) {
    if (empty($u['avatar']) || $u['avatar'] === 'images/defaultAvatar.svg') {
        $u['avatar'] = $base_url . '/images/defaultAvatar.svg';
    } elseif (strpos($u['avatar'], 'http') !== 0) {
        $u['avatar'] = $base_url . '/uploads/avatars/' . $u['avatar'];
    }
    // Envia distância em metros para o frontend, float
    $u['distance_m'] = (float) $u['distance'];
}

echo json_encode([
    'success' => true,
    'users' => $users
]);
