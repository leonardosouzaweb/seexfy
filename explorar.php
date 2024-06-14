<?php
include_once 'includes/head.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./entrar");
    exit(); 
}

include_once 'config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, maritalStatus, username, city, interests, fullname, age, sexualOrientation, sign, height, smokes, drink, experience, description, agePartner, sexualOrientationPartner, signPartner, heightPartner, smokesPartner, drinkPartner, experiencePartner, description, gender, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Buscar endereço do usuário logado
$sqlLocation = "SELECT address FROM user_locations WHERE user_id = ?";
$stmtLocation = $conn->prepare($sqlLocation);
$stmtLocation->bind_param("i", $user_id);
$stmtLocation->execute();
$resultLocation = $stmtLocation->get_result();
$location = $resultLocation->fetch_assoc();

$stmt->close();
$stmtLocation->close();
?>
<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>
    <?php include_once 'includes/topMenu.php'; ?>

    <div class="home">
        <div class="wrapper">
            <div class="content">
                <h2>Explorar</h2>
                <?php if ($location && isset($location['address'])): ?>
                    <p class="location">Você está em: <small><?php echo $location['address']; ?></small></p>
                <?php endif; ?>
                <?php include_once 'includes/radar.php'; ?>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
</body>
</html>
