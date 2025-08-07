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
          <label class="d-flex align-items-center gap-2" for="fileInput" style="cursor:pointer;">
            <i class="ph ph-image" style="font-size: 20px;"></i>
            <span id="fileLabelText">Selecionar Foto</span>
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
          <i class="ph ph-newspaper" style="font-size: 120px; color: #adb5bd;"></i>
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
              <?php if (!empty($post['avatar'])): ?>
                <img src="<?php echo $base_url . '/uploads/' . $post['avatar']; ?>" width="40" height="40" class="rounded-circle" alt="Avatar">
              <?php else: ?>
                <i class="ph ph-user-circle" style="font-size: 40px; color: #6c757d;"></i>
              <?php endif; ?>
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
                <img src="<?php echo $base_url . '/' . $post['image']; ?>" alt="Imagem do post">
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

<!-- Botão flutuante para modo discreto -->
<button id="toggleBlurBtn" title="Ativar modo discreto" 
  style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    border: none;
    background-color: #0d6efd;
    color: white;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 8px rgb(13 110 253 / 0.4);
    z-index: 10000;
  "
  aria-pressed="false"
>
  <i class="ph-eye" style="font-size: 24px;"></i>
</button>

<!-- CSS para animação e blur -->
<style>
  .emoji-animate {
    pointer-events: none;
    user-select: none;
    position: fixed;
    will-change: transform, opacity;
    font-size: 24px;
    z-index: 9999;
  }

  /* Classe para aplicar blur suave nas imagens dos posts */
  .blurred-post-images .contentImage img {
    filter: blur(6px);
    transition: filter 0.5s ease;
  }
</style>

<!-- Scripts JS -->
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
          emojiAnimate.attachListeners(); // Reanexar evento da animação nos novos emojis
        } else {
          document.getElementById('loadingMore').innerHTML = '<span class="text-muted">Nenhuma publicação adicional.</span>';
        }
        loading = false;
      });
  }
});

// Mostrar nome do arquivo no label
const fileInput = document.getElementById('fileInput');
const fileLabelText = document.getElementById('fileLabelText');
fileInput.addEventListener('change', function () {
  const files = this.files;
  let text = 'Selecionar Foto';

  if (files.length === 1) {
    // Só o nome do arquivo, sem caminho
    text = files[0].name;
  } else if (files.length > 1) {
    text = `${files[0].name} +${files.length - 1} arquivos`;
  }

  // Limitar tamanho do texto para evitar quebra
  if (text.length > 30) {
    text = text.substring(0, 27) + '...';
  }

  fileLabelText.textContent = text;
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

// Classe para animação do emoji
class EmojiAnimate {
  constructor() {
    this.emojis = document.querySelectorAll(".reaction-btn");
    this.container = document.querySelector(".emoji-container");
    if (!this.container) {
      this.container = document.createElement('div');
      this.container.className = 'emoji-container';
      this.container.style.position = 'fixed';
      this.container.style.left = 0;
      this.container.style.top = 0;
      this.container.style.width = '100vw';
      this.container.style.height = '100vh';
      this.container.style.pointerEvents = 'none';
      this.container.style.overflow = 'visible';
      this.container.style.zIndex = '9999';
      document.body.appendChild(this.container);
    }
    this.handleEmojiClick = this.handleEmojiClick.bind(this);
    this.addEventListeners();
  }

  addEventListeners() {
    this.emojis.forEach(emoji =>
      emoji.addEventListener("click", this.handleEmojiClick)
    );
  }

  attachListeners() {
    this.emojis = document.querySelectorAll(".reaction-btn");
    this.addEventListeners();
  }

  handleEmojiClick(e) {
    const emojiSpan = e.currentTarget.querySelector('.emoji');
    if (!emojiSpan) return;

    const emojiEl = document.createElement("div");
    emojiEl.classList.add("emoji-animate");
    emojiEl.style.position = 'fixed';
    emojiEl.style.left = '0';
    emojiEl.style.top = '0';
    emojiEl.style.fontSize = '24px';
    emojiEl.style.willChange = 'transform, opacity';
    emojiEl.innerHTML = emojiSpan.innerHTML;

    this.container.appendChild(emojiEl);

    const { left, top, width, height } = emojiSpan.getBoundingClientRect();

    const endX = window.innerWidth / 2 - width / 2;
    const endY = 50;

    emojiEl.style.transform = `translate(${left}px, ${top}px)`;

    const animation = emojiEl.animate(
      [
        { opacity: 1, transform: `translate(${left}px, ${top}px) scale(1)` },
        { opacity: 0, transform: `translate(${endX}px, ${endY}px) scale(2)` }
      ],
      {
        duration: 2000,
        easing: "cubic-bezier(.60,.48,.44,.86)"
      }
    );

    animation.onfinish = () => emojiEl.remove();
  }
}

const emojiAnimate = new EmojiAnimate();

// Botão flutuante modo discreto
const toggleBlurBtn = document.getElementById('toggleBlurBtn');
let blurActive = false;

toggleBlurBtn.addEventListener('click', () => {
  blurActive = !blurActive;
  const postsDiv = document.querySelector('.posts');

  if (blurActive) {
    postsDiv.classList.add('blurred-post-images');
    toggleBlurBtn.title = "Desativar modo discreto";
    toggleBlurBtn.setAttribute('aria-pressed', 'true');
    toggleBlurBtn.innerHTML = '<i class="ph-eye-slash" style="font-size: 24px;"></i>';
  } else {
    postsDiv.classList.remove('blurred-post-images');
    toggleBlurBtn.title = "Ativar modo discreto";
    toggleBlurBtn.setAttribute('aria-pressed', 'false');
    toggleBlurBtn.innerHTML = '<i class="ph-eye" style="font-size: 24px;"></i>';
  }
});
</script>
