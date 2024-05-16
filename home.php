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
                <h1>Explorar</h1>
                <?php 
                    include_once 'includes/explore.php'
                ?>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    <!-- MODAL -->
    <?php include_once 'includes/singleModal.php'; ?>
    <?php include_once 'includes/coupleModal.php'; ?>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script>
        // Monitorar eventos de teclado
        window.addEventListener('keydown', function(event) {
            if (event.key === 'PrintScreen' || (event.key === '4' && event.ctrlKey && event.shiftKey)) {
                alert('A captura de tela foi detectada. O conteúdo está protegido.');
                event.preventDefault(); // Evitar que a ação padrão de tirar um print de tela ocorra
            }
        });

        // Monitorar o evento 'beforeunload'
        window.addEventListener('beforeunload', function(event) {
            alert('Você tentou tirar um print de tela. O conteúdo está protegido.');
        });

        // Monitorar tamanho da janela
        var initialWidth = window.innerWidth;

        window.addEventListener('resize', function() {
            var currentWidth = window.innerWidth;
            if (initialWidth - currentWidth > 100) {
                alert('Você tentou redimensionar a janela para tirar um print de tela. O conteúdo está protegido.');
            }
        });
    </script>
</body>
</html>