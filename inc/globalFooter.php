<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?php
    $current_path = $_SERVER['REQUEST_URI'];

    if (strpos($current_path, '/auth/register.php') !== false) {
        echo '<script src="' . $base_url . '/js/register.js"></script>';
    } elseif (strpos($current_path, '/search/') !== false) {
        echo '<script src="' . $base_url . '/js/results.js"></script>';
    } elseif (strpos($current_path, '/chat/') !== false) {
        echo '<script src="' . $base_url . '/js/chat.js"></script>';
    } elseif (strpos($current_path, '/payment/') !== false) {
        echo '<script src="' . $base_url . '/js/payment.js"></script>';
    } elseif (strpos($current_path, '/profile/') !== false) {
        echo "<script src='https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js'></script>";
    }
?>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     // Verifica se o usuário está acessando de um dispositivo móvel
    //     if (!/Mobi|Android/i.test(navigator.userAgent)) {
    //         // Redireciona para uma página de instruções ou exibe uma mensagem
    //         document.body.innerHTML = `
    //             <div class="infoDesktop">
    //                 <img src="<?php echo $base_url; ?>/images/logo.svg">
    //                 <h1>Acesso Restrito!</h1>
    //                 <p>Por favor, acesse este site pelo seu celular.</p>
    //             </div>
    //         `;
    //     }
    // });
</script>
</body>
</html>