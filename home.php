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

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    exit("Erro: Usuário não encontrado");
}

$stmt->close();
?>

<body>
    <div class="empty">
        <img src="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>assets/images/logo.svg">
    </div>
    <?php include_once 'includes/topMenu.php'; ?>
    <div class="home">
        <div class="wrapper">
            <div class="content">
                <h2>Explorar</h2>
                <?php 
                    include_once 'includes/explore.php';
                ?>
            </div>
        </div>
    </div>
    <?php include_once 'includes/bottomMenu.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>assets/js/functions.js"></script>
</body>
</html>
