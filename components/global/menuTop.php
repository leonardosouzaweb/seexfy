<?php
include_once '../inc/db.php';

$user_id = $_SESSION['user_id'] ?? null;

$avatar = $base_url . '/uploads/images/defaultAvatar.svg';
$username = 'Usuário';
$notification_count = 0;

if ($user_id) {
    // Dados do usuário
    $stmt = $pdo->prepare("SELECT username, avatar FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $username = htmlspecialchars($user['username']);
        if (!empty($user['avatar'])) {
            $avatar = $base_url . '/uploads/avatars/' . $user['avatar'];
        }
    }

    // Contador de notificações não lidas
    $notifStmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $notifStmt->execute([$user_id]);
    $notification_count = $notifStmt->fetchColumn();
}
?>

<div class="heading">
    <div class="container">
        <div class="logo">
            <a href="<?php echo $base_url; ?>/home">
                <img src="<?php echo $base_url; ?>/images/logo.svg" alt="Logo">
            </a>
        </div>

        <div class="group">
            <div class="search">
                <a href="<?php echo $base_url; ?>/search" title="Buscar">
                    <i class="ph ph-magnifying-glass"></i>
                </a>
            </div>

            <div class="notification">
                <?php if ($notification_count > 0): ?>
                    <span><?= $notification_count ?></span>
                <?php endif; ?>
                <a href="<?php echo $base_url; ?>/notification" title="Notificações">
                    <i class="ph ph-bell"></i>
                </a>
            </div>

            <div class="avatar" data-bs-toggle="offcanvas" href="#menuMobile" role="button" aria-controls="menuMobile">
                <img src="<?= $avatar ?>" alt="Avatar">
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-start" tabindex="-1" id="menuMobile" aria-labelledby="menuMobileLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="menuMobileLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <div class="avatar">
            <div>
                <img src="<?= $avatar ?>" alt="Avatar">
            </div>
            <div>
                <span><?= $username ?></span>
                <a href="<?= $base_url ?>/profile/<?= urlencode($username) ?>"><p>Ver Perfil</p></a>
            </div>
        </div>

        <ul>
            <li>
                <a href="<?php echo $base_url; ?>/monetization">
                    <i class="ph ph-coins"></i> Monetize
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/home">
                    <i class="ph ph-house"></i> Explorar
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/feed">
                    <i class="ph ph-newspaper"></i> Feed
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/radar">
                    <i class="ph ph-map-pin"></i> Radar
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/payment">
                    <i class="ph ph-credit-card"></i> Assinatura
                </a>
            </li>
            <li>
                <a href="<?php echo $base_url; ?>/help">
                    <i class="ph ph-question"></i> Ajuda
                </a>
            </li>
            <li>
                <a href="<?= $base_url ?>/api/logout.php">
                    <i class="ph ph-sign-out"></i> Sair
                </a>
            </li>
        </ul>
    </div>
</div>
