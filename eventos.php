<?php
    include_once 'includes/head.php';
    session_start(); 

    if (!isset($_SESSION['user_id'])) {
        header("Location: ./entrar");
        exit(); 
    }

    include_once 'config/db.php';

    $user_id = $_SESSION['user_id'];
    $sqlUser = "SELECT maritalStatus, username, avatar FROM users WHERE id = ?";
    $stmt = $conn->prepare($sqlUser);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $stmt->close();
    $conn->close();
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
                <h1>Eventos</h1>
                <?php 
                    include_once 'includes/events.php'
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