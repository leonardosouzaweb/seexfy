<?php
include_once 'includes/head.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./entrar");
    exit(); 
}

include_once 'config/db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, maritalStatus, username, city, interests, fullname, age, sexualOrientation, sign, height, smokes, drink, experience, description, agePartner, sexualOrientationPartner, signPartner, heightPartner, smokesPartner, drinkPartner, experiencePartner, description, gender, avatar, verification FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
?>
<body>
    <div class="empty">
        <img src="<?php echo $base_url; ?>assets/images/logo.svg">
    </div>

    <div class="home">
        <div class="wrapper">
            <?php 
                include_once 'includes/topMenu.php';
            ?>

            <div class="content">
                <h2>Explorar</h2>
                <?php 
                    include_once 'includes/radar.php'
                ?>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/js/functions.js"></script>
</body>
</html>