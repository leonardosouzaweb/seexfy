<?php
include_once 'inc/globalHead.php';

// Verifica se o usuário está logado
if (isset($_SESSION['user_id'])) {
    header('Location: home/');
    exit;
}
?>
<main>
    <div class="login">
        <div class="wrapper">
            <div class="logo">
                <img src="images/logo.svg">
            </div>

            <a href="auth/register.php" class="btnEnter"><button>Cadastrar</button></a>
            <a href="auth/login.php" class="btnLogin"><button>Entrar</button></a>
            <small>Ao selecionar cadastrar ou entrar, você concorda com nossos 
                <a href="#">Termos de Uso.</a> Saiba como tratamos seus dados em nossa 
                <a href="#">Política de Privacidade</a>
            </small>
        </div>
    </div>
</main>
<?php include_once 'inc/globalFooter.php'; ?>
