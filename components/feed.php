<?php include_once '../inc/db.php'; ?>
<?php session_start(); ?>

<?php
$emoji_map = [
  'fogo' => '🔥',
  'diabinho' => '😈',
  'surpreso' => '😮',
  'safado' => '😏',
  'aplausos' => '👏',
  'coração' => '❤️'
];
?>

<div class="feedP">
  <div class="container">
    <h1>Feed</h1>
    <!-- Formulário de publicação -->
    <form action="../api/post.php" method="POST" enctype="multipart/form-data" class="postAction">
        <div>
          <textarea name="content" class="form-control" rows="3" placeholder="Escreva algo..." style="resize: none;"></textarea>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-2">
          <label class="d-flex align-items-center gap-2">
            <span id="fileLabelText">Selecione uma foto</span>
            <input type="file" name="image" accept="image/*" hidden id="fileInput">
          </label>

          <button type="submit" class="btn btn-primary btn-sm">Publicar</button>
        </div>
    </form>

    <!-- Listagem de posts -->
    <div class="posts">
      <?php
      $stmt = $pdo->prepare("SELECT posts.*, users.username, users.avatar FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT 10");
      $stmt->execute();
      $posts = $stmt->fetchAll();

      if (count($posts) === 0): ?>
        <div class="text-center my-5">
          <img src="<?php echo $base_url; ?>/images/no-posts.png" alt="Sem publicações" style="width: 120px;">
          <span class="d-block mt-3 text-muted">Não existem publicações</span>
        </div>
      <?php endif; ?>

      <?php foreach ($posts as $post):
        $reactionStmt = $pdo->prepare("SELECT emoji_key, COUNT(*) as total FROM post_reactions WHERE post_id = ? GROUP BY emoji_key");
        $reactionStmt->execute([$post['id']]);
        $reactions = $reactionStmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $userReactionStmt = $pdo->prepare("SELECT emoji_key FROM post_reactions WHERE post_id = ? AND user_id = ?");
        $userReactionStmt->execute([$post['id'], $_SESSION['user_id']]);
        $userReaction = $userReactionStmt->fetchColumn();
      ?>
        <div class="card">
          <div class="head">
            <div>
              <img src="<?php echo $base_url . '/uploads/' . ($post['avatar'] ?: 'images/defaultAvatar.svg'); ?>" width="40" height="40" class="rounded-circle">
            </div>
            <div>
              <span><?php echo htmlspecialchars($post['username']); ?></span>
              <small><?php echo date('d/m/Y \à\s H:i', strtotime($post['created_at'])); ?>h</small>
            </div>
            <div>
              <button>Interagir</button>
            </div>
          </div>

          <div class="content">
            <div class="contentImage">
              <?php if (!empty($post['image'])): ?>
                <img src="<?php echo $base_url . '/' . $post['image']; ?>">
              <?php endif; ?>
              <div class="mask"></div>
            </div>
            <span><?php echo nl2br(htmlspecialchars($post['content'])); ?></span>
          </div>

          <div class="emoji-list" data-post-id="<?php echo $post['id']; ?>">
            <ul class="flex gap-2">
              <?php foreach ($emoji_map as $key => $emoji): ?>
              <li
                class="reaction-btn <?php echo ($userReaction === $key) ? 'active' : ''; ?>"
                data-emoji="<?php echo $key; ?>"
              >
                <span class="emoji"><?php echo $emoji; ?></span>
              </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Spinner de carregando -->
    <div id="loadingMore" class="text-center my-4" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Carregando...</span>
      </div>
    </div>
  </div>
</div>

<script>
let offset = 10;
let loading = false;
let reactionCooldown = {}; // Para evitar spam de reações por post

// Scroll infinito
window.addEventListener('scroll', () => {
  if (loading) return;
  const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
  if (scrollTop + clientHeight >= scrollHeight - 100) {
    loading = true;
    document.getElementById('loadingMore').style.display = 'block';
    fetch(`../api/loadMorePost.php?offset=${offset}`)
      .then(res => res.text())
      .then(html => {
        if (html.trim()) {
          document.querySelector('.posts').insertAdjacentHTML('beforeend', html);
          offset += 10;
          attachReactions(); // Reanexar eventos às novas reações
        } else {
          document.getElementById('loadingMore').innerHTML = '<span class="text-muted">Nenhuma publicação adicional.</span>';
        }
        loading = false;
      });
  }
});

// Mostrar nome do arquivo
const fileInput = document.getElementById('fileInput');
const fileLabelText = document.getElementById('fileLabelText');
fileInput.addEventListener('change', function () {
  const fileName = this.files[0]?.name || 'Selecione uma foto';
  fileLabelText.textContent = fileName;
});

// Função para anexar evento de reação
function attachReactions() {
  document.querySelectorAll('.reaction-btn').forEach(btn => {
    btn.onclick = () => {
      const emojiKey = btn.dataset.emoji;
      const postId = btn.closest('.emoji-list').dataset.postId;
      const parent = btn.closest('ul');

      // Bloquear múltiplos cliques rápidos no mesmo post
      if (reactionCooldown[postId]) return;
      if (btn.classList.contains('active')) return;

      reactionCooldown[postId] = true;

      fetch('../api/reactPost.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `post_id=${postId}&emoji=${encodeURIComponent(emojiKey)}`
      }).then(res => {
        if (res.ok) {
          parent.querySelectorAll('li').forEach(el => el.classList.remove('active'));
          btn.classList.add('active');
        }
      }).finally(() => {
        setTimeout(() => { reactionCooldown[postId] = false }, 1000); // 1s cooldown
      });
    }
  });
}
attachReactions();
</script>
