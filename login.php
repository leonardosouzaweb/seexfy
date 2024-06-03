<?php 
include_once 'includes/head.php';
include_once 'config/db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Senha incorreta.";
        }
    } else {
        $error = "Usuário não encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
<body>
    <div class="login">
        <div class="wrapper">
            <div class="logo">
                <img src="assets/images/logo.svg">
                <span>REDE DE ENCONTROS E DESCOBERTAS</span>
            </div>

            <form method="POST">
                <?php if (isset($error)): ?>
                    <div id="errorAlert" class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <label>Digite o email</label>
                <input type="text" class="form-control" name="email" required>

                <label>Digite sua senha</label>
                <input type="password" class="form-control" name="senha" required>
                <button type="submit">Entrar</button>
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
