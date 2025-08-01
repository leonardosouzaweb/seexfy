<?php
session_start();
include_once '../inc/globalHead.php';
?>
<main>
  <div class="login">
    <div class="wrapper">
      <div class="logo">
        <img src="<?php echo $base_url; ?>/images/logo.svg">
      </div>

      <form method="post" action="loginHandler.php">
        <input type="email" class="form-control" name="email" placeholder="Digite seu e-mail" required>
        <input type="password" class="form-control" name="password" placeholder="Senha" required>
        <button type="submit">Entrar</button>
      </form>
    </div>
    <!-- Toast container -->
    <div id="toast-container" class="pos"></div>
  </div>
</main>
<?php include_once '../inc/globalFooter.php'; ?>

<?php if (isset($_SESSION['login_error'])): ?>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const message = <?php echo json_encode($_SESSION['login_error']); ?>;

      const toastContainer = document.getElementById('toast-container');

      const toastEl = document.createElement('div');
      toastEl.className = 'toast align-items-center text-bg-danger border-0 alertToast';
      toastEl.setAttribute('role', 'alert');
      toastEl.setAttribute('aria-live', 'assertive');
      toastEl.setAttribute('aria-atomic', 'true');

      toastEl.innerHTML = `
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fechar"></button>
        </div>
      `;

      toastContainer.appendChild(toastEl);

      const bsToast = new bootstrap.Toast(toastEl, { delay: 4000 });
      bsToast.show();
    });
  </script>
  <?php unset($_SESSION['login_error']); ?>
<?php endif; ?>
