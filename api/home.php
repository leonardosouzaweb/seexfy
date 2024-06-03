<?php
// Inclua o cabeçalho e inicie a sessão, se necessário
include_once 'includes/head.php';
session_start();

// Verifique se o usuário está autenticado, se necessário
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); 
}

// Inclua o arquivo de configuração do banco de dados
include_once 'config/db.php';

// Obtenha o ID do usuário da sessão
$user_id = $_SESSION['user_id'];

// Verifique se foram passadas as coordenadas geográficas do navegador
if(isset($_POST['latitude']) && isset($_POST['longitude'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Consulta SQL para calcular a distância e ordenar os resultados com base nela
    $sql = "SELECT maritalStatus, username, city, interests, fullname, age, sexualOrientation, sign, height, smokes, drink, experience, description, gender, (6371 * acos(cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude)) + sin(radians($latitude)) * sin(radians(latitude)))) AS distance FROM users WHERE id != ? ORDER BY distance";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
} else {
    // Tratamento de erro se as coordenadas não forem recebidas
    echo "Erro: Coordenadas geográficas não recebidas.";
    exit();
}

// Lógica para manipular os resultados, se necessário
?>
