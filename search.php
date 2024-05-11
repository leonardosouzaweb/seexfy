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
                <h1>Pesquisar</h1>
                <input type="text" class="form-control" placeholder="Buscar perfil...">
                <?php 
                    include_once 'includes/resultSearch.php'
                ?>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    <!-- MODAL -->
    <?php include_once 'includes/userModal.php'; ?>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
</body>
</html>