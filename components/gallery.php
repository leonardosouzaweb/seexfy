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
    <div class="photo-slot filled" onclick="openGallery(<?= $index ?>)">
      <img src="<?= $base_url . '/uploads/gallery/' . htmlspecialchars($photo['filename']) ?>" alt="Foto">
      <?php if ($isOwnProfile): ?>
        <form method="POST" action="../api/deletePhotoProfile.php" onsubmit="return confirm('Deseja remover esta foto?');">
          <input type="hidden" name="photo_id" value="<?= $photo['id'] ?>">
          <button type="submit" class="remove-btn">×</button>
        </form>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>

  <?php if ($isOwnProfile): ?>
    <?php for ($i = 0; $i < $remainingSlots; $i++): ?>
      <div class="photo-slot empty">
        <form action="../api/uploadPhotoProfile.php" method="POST" enctype="multipart/form-data">
          <label class="add-btn">
            <input type="file" name="photo" accept="image/*" onchange="this.form.submit()" hidden>
            +
          </label>
        </form>
      </div>
    <?php endfor; ?>
  <?php endif; ?>
</div>

<!-- Galeria Modal Swiper -->
<dialog id="galleryModal" class="gallery-modal">
  <swiper-container id="swiperGallery" loop="true" navigation="true">
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

  // Aplica estilo diretamente via JavaScript dentro do Shadow DOM
  setTimeout(() => {
    try {
      const nextBtn = swiper.shadowRoot.querySelector(".swiper-button-next");
      const prevBtn = swiper.shadowRoot.querySelector(".swiper-button-prev");

      if (nextBtn) {
        nextBtn.style.color = "#fff";
        nextBtn.style.fontSize = "32px";
        nextBtn.style.width = "25px";
        nextBtn.style.height = "25px";
      }

      if (prevBtn) {
        prevBtn.style.color = "#fff";
        prevBtn.style.fontSize = "32px";
        prevBtn.style.width = "25px";
        prevBtn.style.height = "25px";
      }
    } catch (e) {
      console.warn("Erro ao aplicar estilo nos botões do swiper:", e);
    }
  }, 200);
}

function closeGallery() {
  const modal = document.getElementById("galleryModal");
  if (modal) {
    modal.close();
  }
}


</script>
