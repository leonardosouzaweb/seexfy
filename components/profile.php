<?php
include_once '../inc/globalHead.php';
include_once '../inc/db.php';

$requestedUsername = $_GET['username'] ?? null;
$isOwnProfile = false;

if ($requestedUsername) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$requestedUsername]);
    $user = $stmt->fetch();
} elseif (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $isOwnProfile = true;
} else {
    header('Location: ../auth/login.php');
    exit;
}

if ($requestedUsername && isset($_SESSION['user_id']) && $user && $user['id'] == $_SESSION['user_id']) {
    $isOwnProfile = true;
}

if (!$user) {
    echo "Usuário não encontrado.";
    exit;
}

function safeJsonDecode($jsonString) {
    $jsonString = trim($jsonString);
    if ($jsonString === '' || $jsonString === 'null') {
        return [];
    }
    $decoded = json_decode($jsonString, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }
    return $decoded;
}

$username = htmlspecialchars($user['username']);
$city = htmlspecialchars($user['city']);
$marital = strtolower($user['marital_status']);
$interests = safeJsonDecode($user['interests'] ?? '[]');
$avatar = $user['avatar'] ? $base_url . '/uploads/' . $user['avatar'] : $base_url . '/uploads/images/defaultAvatar.svg';

$idade = htmlspecialchars($user['idade'] ?? '');
$orientacao = htmlspecialchars($user['orientacao'] ?? '');
$signo = htmlspecialchars($user['signo'] ?? '');
$altura = htmlspecialchars($user['altura'] ?? '');
$fuma = htmlspecialchars($user['fuma'] ?? '');
$bebe = htmlspecialchars($user['bebe'] ?? '');
$experiencia = htmlspecialchars($user['experiencia'] ?? '');

$partner = [];
$partnerInterests = [];

if (in_array($marital, ['casado', 'casada'])) {
    $stmt = $pdo->prepare("SELECT * FROM partner_profiles WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $partner = $stmt->fetch() ?: [];
    $partnerInterests = safeJsonDecode($partner['interests'] ?? '[]');
}
?>

<main class="profileP">
  <div class="container">
    <div class="avatar">
      <div>
        <?php if ($isOwnProfile): ?>
        <form id="avatarForm" action="../api/uploadAvatar.php" method="POST" enctype="multipart/form-data" style="display:none;">
          <input type="file" name="avatar" id="avatarInput" accept="image/*">
        </form>
        <?php endif; ?>

        <img src="<?= $avatar ?>" alt="Avatar" style="cursor: <?= $isOwnProfile ? 'pointer' : 'default' ?>;">
        <?php if ($isOwnProfile): ?>
        <div class="upload">
          <img src="<?= $base_url ?>/images/icons/black/iconUpload.svg" alt="Upload" onclick="document.getElementById('avatarInput').click();" class="icon">
        </div>
        <?php endif; ?>
      </div>

      <div>
        <span><?= $username ?></span>
        <p><?= $city ?></p>
      </div>

      <div>
        <?php if (!$isOwnProfile): ?>
        <button>Interagir</button>
        <?php endif; ?>
      </div>
    </div>

    <?php if (in_array($marital, ['casado', 'casada'])): ?>
    <!-- Casados -->
    <div class="profileDetailGroup">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="man-tab" data-bs-toggle="tab" data-bs-target="#man-tab-pane" type="button" role="tab">Homem</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="woman-tab" data-bs-toggle="tab" data-bs-target="#woman-tab-pane" type="button" role="tab">Mulher</button>
        </li>
      </ul>

      <div class="tab-content pt-3">
        <!-- Aba Homem -->
        <div class="tab-pane fade show active" id="man-tab-pane" role="tabpanel">
          <h3>
            Informações
            <?php if ($isOwnProfile): ?>
              <img src="<?= $base_url ?>/images/icons/black/iconEditProfile.svg" class="ms-2" data-bs-toggle="modal" data-bs-target="#modalEditUser" style="cursor:pointer;">
            <?php endif; ?>
          </h3>
          <ul>
            <li>Idade: <span><?= $idade ?></span></li>
            <li>Orientação Sexual: <span><?= $orientacao ?></span></li>
            <li>Signo: <span><?= $signo ?></span></li>
            <li>Altura: <span><?= $altura ?></span></li>
            <li>Fuma: <span><?= $fuma ?></span></li>
            <li>Bebe: <span><?= $bebe ?></span></li>
            <li>Experiência no Liberal: <span><?= $experiencia ?></span></li>
          </ul>

          <h3>Interesses</h3>
          <p><?= !empty($interests) ? implode(', ', array_map('htmlspecialchars', $interests)) : 'Sem interesses cadastrados' ?></p>
        </div>

        <!-- Aba Mulher -->
        <div class="tab-pane fade" id="woman-tab-pane" role="tabpanel">
          <h3>
            Informações
            <?php if ($isOwnProfile): ?>
              <img src="<?= $base_url ?>/images/icons/black/iconEditProfile.svg" class="ms-2" data-bs-toggle="modal" data-bs-target="#modalEditPartner" style="cursor:pointer;">
            <?php endif; ?>
          </h3>
          <ul>
            <li>Idade: <span><?= htmlspecialchars($partner['idade'] ?? '-') ?></span></li>
            <li>Orientação Sexual: <span><?= htmlspecialchars($partner['orientacao'] ?? '-') ?></span></li>
            <li>Signo: <span><?= htmlspecialchars($partner['signo'] ?? '-') ?></span></li>
            <li>Altura: <span><?= htmlspecialchars($partner['altura'] ?? '-') ?></span></li>
            <li>Fuma: <span><?= htmlspecialchars($partner['fuma'] ?? '-') ?></span></li>
            <li>Bebe: <span><?= htmlspecialchars($partner['bebe'] ?? '-') ?></span></li>
            <li>Experiência no Liberal: <span><?= htmlspecialchars($partner['experiencia'] ?? '-') ?></span></li>
          </ul>

          <h3>Interesses</h3>
          <p><?= !empty($partnerInterests) ? implode(', ', array_map('htmlspecialchars', $partnerInterests)) : 'Sem interesses cadastrados' ?></p>
        </div>
      </div>

      <h3 class="mt-4">Galeria de Fotos</h3>
      <div class="photos"><?php include_once '../components/gallery.php'; ?></div>
    </div>

    <?php else: ?>
    <!-- Solteiros -->
    <div class="profileDetailtSingle">
      <h3>
        Informações 
        <?php if ($isOwnProfile): ?>
          <img src="<?= $base_url ?>/images/icons/black/iconEditProfile.svg" data-bs-toggle="modal" data-bs-target="#modalEditUser" style="cursor:pointer;">
        <?php endif; ?>
      </h3>
      <ul>
        <li>Idade: <span><?= $idade ?></span></li>
        <li>Orientação Sexual: <span><?= $orientacao ?></span></li>
        <li>Signo: <span><?= $signo ?></span></li>
        <li>Altura: <span><?= $altura ?></span></li>
        <li>Fuma: <span><?= $fuma ?></span></li>
        <li>Bebe: <span><?= $bebe ?></span></li>
        <li>Experiência no Liberal: <span><?= $experiencia ?></span></li>
      </ul>

      <h3>Interesses</h3>
      <p><?= !empty($interests) ? implode(', ', array_map('htmlspecialchars', $interests)) : 'Sem interesses cadastrados' ?></p>

      <h3 class="mt-4">Galeria de Fotos</h3>
      <div class="photos"><?php include_once '../components/gallery.php'; ?></div>
    </div>
    <?php endif; ?>
  </div>
</main>

<!-- Modais -->
<?php include_once '../components/modals/modalEditUser.php'; ?>
<?php include_once '../components/modals/modalEditPartner.php'; ?>
<?php include_once '../inc/globalFooter.php'; ?>

<?php if ($isOwnProfile): ?>
<script>
  document.getElementById('avatarInput').addEventListener('change', function () {
    if (this.files.length > 0) {
      document.getElementById('avatarForm').submit();
    }
  });
</script>
<?php endif; ?>
