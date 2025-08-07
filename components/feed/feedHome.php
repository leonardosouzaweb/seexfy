<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../inc/globalHead.php'; 
include_once '../inc/db.php';

// Buscar usuários cadastrados
$stmt = $pdo->prepare("
  SELECT 
    username,
    city,
    avatar,
    idade,
    orientacao,
    signo,
    altura,
    fuma,
    bebe,
    experiencia,
    interests
  FROM users
  ORDER BY created_at DESC
  LIMIT 30
");

$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main>
  <div class="feed">

    <!-- Stories (opcional, ainda ocultos) -->
    <div class="stories" style="display:none;">
      <div data-bs-toggle="modal" data-bs-target="#modalStorie"><img src="<?php echo $base_url; ?>/images/stories/1.png"></div>
    </div>

    <div class="container">
      <h1>Explorar</h1>

      <div class="cards">
        <?php foreach ($users as $user): ?>
          <div class="user-card" 
              data-bs-toggle="modal" 
              data-bs-target="#modalUser"
              data-username="<?php echo htmlspecialchars($user['username']); ?>"
              data-city="<?php echo htmlspecialchars($user['city']); ?>"
              data-avatar="<?php echo !empty($user['avatar']) ? $base_url . '/uploads/' . $user['avatar'] : $base_url . '/uploads/images/defaultAvatar.svg'; ?>"
              data-idade="<?php echo $user['idade'] ?? ''; ?>"
              data-orientacao="<?php echo $user['orientacao'] ?? ''; ?>"
              data-signo="<?php echo $user['signo'] ?? ''; ?>"
              data-altura="<?php echo $user['altura'] ?? ''; ?>"
              data-fuma="<?php echo $user['fuma'] ?? ''; ?>"
              data-bebe="<?php echo $user['bebe'] ?? ''; ?>"
              data-experiencia="<?php echo $user['experiencia'] ?? ''; ?>"
              data-interests="<?php echo htmlspecialchars($user['interests'] ?? ''); ?>"
              data-descricao="<?php echo htmlspecialchars($user['descricao'] ?? ''); ?>">
            <img src="<?php echo !empty($user['avatar']) ? $base_url . '/uploads/' . $user['avatar'] : $base_url . '/uploads/images/defaultAvatar.svg'; ?>" alt="Avatar">
            <div class="info">
              <span><?php echo htmlspecialchars($user['username']); ?></span>
              <small><?php echo htmlspecialchars($user['city']); ?></small>
            </div>
            <div class="mask"></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

  </div>
</main>

<?php include_once '../inc/globalFooter.php'; ?>

<script>
  document.querySelectorAll('.user-card').forEach(card => {
  card.addEventListener('click', () => {
    const modal = document.getElementById('modalUser');
    modal.querySelector('.avatar img').src = card.dataset.avatar;
    modal.querySelector('.avatar span').textContent = card.dataset.username;
    modal.querySelector('.avatar p').textContent = card.dataset.city;

    // ✅ Atualiza link do botão "Quero conhecer"
    modal.querySelector('#queroConhecerBtn').href = `<?= $base_url ?>/profile/${encodeURIComponent(card.dataset.username)}`;

    modal.querySelector('.info span[data-field="idade"]').textContent = card.dataset.idade || '-';
    modal.querySelector('.info span[data-field="orientacao"]').textContent = card.dataset.orientacao || '-';
    modal.querySelector('.info span[data-field="signo"]').textContent = card.dataset.signo || '-';
    modal.querySelector('.info span[data-field="altura"]').textContent = card.dataset.altura || '-';
    modal.querySelector('.info span[data-field="fuma"]').textContent = card.dataset.fuma || '-';
    modal.querySelector('.info span[data-field="bebe"]').textContent = card.dataset.bebe || '-';
    modal.querySelector('.info span[data-field="experiencia"]').textContent = card.dataset.experiencia || '-';

    try {
      const interesses = JSON.parse(card.dataset.interests || '[]');
      modal.querySelector('.info .interesses').textContent = Array.isArray(interesses) && interesses.length > 0 
        ? interesses.join(', ')
        : '-';
    } catch (e) {
      modal.querySelector('.info .interesses').textContent = '-';
    }

    modal.querySelector('.info .descricao').textContent = card.dataset.descricao || '-';
  });
});
</script>
