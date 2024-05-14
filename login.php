<?php 
    include_once 'includes/head.php';

    $invalidCredentials = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuarios = array(
            "teste@teste.com" => "123"
        );

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        if (array_key_exists($email, $usuarios) && $usuarios[$email] == $senha) {
            header("Location: home.php");
            exit();
        } else {
            $invalidCredentials = true;
        }
    }
?>
<?php 
    include_once 'includes/head.php';
?>
<body>
    <div class="login">
        <div class="wrapper">
            <div class="logo">
                <img src="assets/images/logo.svg">
            </div>

            <form action="#" method="POST">
                <?php if ($invalidCredentials): ?>
                    <div id="errorAlert" class="alert alert-danger" role="alert">
                        Credenciais inválidas. Por favor, tente novamente.
                    </div>
                <?php endif; ?>

                <label>Digite seu e-mail</label>
                <input type="text" class="form-control" name="email">

                <label>Digite sua senha</label>
                <input type="password" class="form-control" name="senha">
                <a href="" class="btnAccess"><button type="submit">Entrar</button></a>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" ></script>
    <script>
        setTimeout(function() {
            $('#errorAlert').fadeOut('slow');
        }, 2000);
    </script>
</body>
</html>
