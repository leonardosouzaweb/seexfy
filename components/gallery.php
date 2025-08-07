<?php
$galleryPhotos = [];
$userId = $user['id'] ?? null;

if ($userId) {
  $stmt = $pdo->prepare("SELECT * FROM user_photos WHERE user_id = ? ORDER BY id ASC");
  $stmt->execute([$userId]);
  $galleryPhotos = $stmt->fetchAll();
}

$totalSlots = 6;
$currentCount = count($galleryPhotos);
$remainingSlots = $totalSlots - $currentCount;
?>

<div class="photo-grid">
  <?php foreach ($galleryPhotos as $index => $photo): ?>
    <div class="photo-slot filled" onclick="openGallery(<?= $index ?>)" style="position:relative;">
      <img src="<?= $base_url . '/uploads/gallery/' . htmlspecialchars($photo['filename']) ?>" alt="Foto">
      <?php if ($isOwnProfile): ?>
        <form method="POST" action="../api/deletePhotoProfile.php" onsubmit="return confirm('Deseja remover esta foto?');" onclick="event.stopPropagation()">
          <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
          <button type="submit" class="remove-btn" aria-label="Remover foto" title="Remover foto" onclick="event.stopPropagation()">
            <i class="ph ph-x"></i>
          </button>
        </form>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <?php if ($isOwnProfile): ?>
    <?php for ($i = 0; $i < $remainingSlots; $i++): ?>
      <div class="photo-slot empty">
        <form action="../api/uploadPhotoProfile.php" method="POST" enctype="multipart/form-data">
          <label class="add-btn" aria-label="Adicionar foto" title="Adicionar foto">
            <input type="file" name="photo" accept="image/*" onchange="this.form.submit()" hidden>
            <i class="ph ph-plus"></i>
          </label>
        </form>
      </div>
    <?php endfor; ?>
  <?php endif; ?>
</div>

<!-- Galeria Modal Swiper -->
<dialog id="galleryModal" class="gallery-modal">
  <swiper-container id="swiperGallery" loop="true">
    <?php foreach ($galleryPhotos as $photo): ?>
      <swiper-slide>
        <img src="<?= $base_url . '/uploads/gallery/' . htmlspecialchars($photo['filename']) ?>" alt="Foto grande" />
      </swiper-slide>
    <?php endforeach; ?>
  </swiper-container>
  <button onclick="closeGallery()" class="close-gallery">×</button>
</dialog>

<script>
function openGallery(startIndex = 0) {
  const modal = document.getElementById("galleryModal");
  const swiper = document.getElementById("swiperGallery");

  if (swiper.swiper) {
    swiper.swiper.slideToLoop(startIndex);
  }

  modal.showModal();
}

function closeGallery() {
  const modal = document.getElementById("galleryModal");
  if (modal) {
    modal.close();
  }
}
</script>
