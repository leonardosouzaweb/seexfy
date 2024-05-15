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
                <?php 
                    include_once 'includes/profile.php'
                ?>
            </div>

            <?php 
                include_once 'includes/bottomMenu.php';
            ?>
        </div>
    </div>
    <!-- END -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/functions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper", {
            slidesPerView: "auto",
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        document.querySelectorAll('.like').forEach(item => {
            item.addEventListener('click', event => {
                // Obtém a imagem dentro da div "like"
                var img = item.querySelector('img');
                // Verifica se a imagem atual é a imagem normal ou a imagem ativa
                if (img.src.includes('iconHeart.svg')) {
                    // Se for a imagem normal, troca para a imagem ativa
                    img.src = 'assets/images/icons/iconHeartActive.svg';
                } else {
                    // Se for a imagem ativa, troca para a imagem normal
                    img.src = 'assets/images/icons/iconHeart.svg';
                }
            });
        });
    </script>
</body>
</html>