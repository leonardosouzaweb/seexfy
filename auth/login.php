<?php include_once '../inc/globalHead.php'?>
<main>
    <div class="login">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo $base_url; ?>/images/logo.svg">
            </div>

            <form method="post" action="../home">
                <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail" required>
                <input type="password" class="form-control" name="password" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>
        </div>
    </div>
</main>
<?php include_once '../inc/globalFooter.php'?>