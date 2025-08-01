<?php
include_once '../inc/db.php';
session_start();

$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$limit = 10;

$emoji_map = [
  'fogo' => '🔥',
  'diabinho' => '😈',
  'surpreso' => '😮',
  'safado' => '😏',
  'aplausos' => '👏',
  'coração' => '❤️'
];

// Buscar mais posts
$stmt = $pdo->prepare("SELECT posts.*, users.username, users.avatar FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC LIMIT ? OFFSET ?");
$stmt->bindValue(1, $limit, PDO::PARAM_INT);
$stmt->bindValue(2, $offset, PDO::PARAM_INT);
$stmt->execute();
$posts = $stmt->fetchAll();

if (count($posts) === 0) {
  exit; // Nenhum novo post
}

foreach ($posts as $post):
  // Buscar reações do post
  $reactionStmt = $pdo->prepare("SELECT emoji_key, COUNT(*) as total FROM post_reactions WHERE post_id = ? GROUP BY emoji_key");
  $reactionStmt->execute([$post['id']]);
  $reactions = $reactionStmt->fetchAll(PDO::FETCH_KEY_PAIR);

  // Reação do usuário
  $userReactionStmt = $pdo->prepare("SELECT emoji_key FROM post_reactions WHERE post_id = ? AND user_id = ?");
  $userReactionStmt->execute([$post['id'], $_SESSION['user_id']]);
  $userReaction = $userReactionStmt->fetchColumn();
?>
  <div class="card">
    <div class="head">
      <div>
        <img src="<?php echo $base_url . '/uploads/' . ($post['avatar'] ?: 'images/defaultAvatar.svg'); ?>">
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
      <?php if (!empty($post['image'])): ?>
        <img src="<?php echo $base_url . '/' . $post['image']; ?>">
      <?php endif; ?>
      <span><?php echo nl2br(htmlspecialchars($post['content'])); ?></span>
      <div class="mask"></div>
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
