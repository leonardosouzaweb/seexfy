<?php 
    session_start();
    function sanitize_output($buffer) {
        return htmlspecialchars($buffer, ENT_QUOTES, 'UTF-8');
    }

    ob_start("sanitize_output");

    if (isset($_SESSION['user_id'])) {
        header("Location: ./home");
        exit();
    }

    include_once 'includes/head.php';
?>
<body>
    <div class="login">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo htmlspecialchars($base_url, ENT_QUOTES, 'UTF-8'); ?>assets/images/logo.svg">
            </div>

            <a href="<?php echo htmlspecialchars('./registro', ENT_QUOTES, 'UTF-8'); ?>" class="btnEnter"><button>Cadastrar</button></a>
            <a href="<?php echo htmlspecialchars('./entrar', ENT_QUOTES, 'UTF-8'); ?>" class="btnLogin"><button>Entrar</button></a>
            <small>Ao selecionar cadastrar ou entrar, você concorda com nossos <a href="#">Termos de Uso.</a> Saiba como tratamos seus dados em nossa <a href="#">Política de Privacidade</a></small>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
