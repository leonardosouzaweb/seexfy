<?php 
    include_once 'includes/head.php';
?>
<body>
    <div class="empty">
        <img src="assets/images/logo.svg">
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
    <script src="assets/js/functions.js"></script>
</body>
</html>