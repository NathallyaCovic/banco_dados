<?php
require_once "db.php";
$id_sala = isset($_GET['sala']) ? intval($_GET['sala']) : 1;
$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

$sql = "SELECT c.*, u.avatar FROM tb_chat c LEFT JOIN tb_usuarios u ON c.user_id = u.id WHERE c.id_sala = ? ORDER BY c.id ASC";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i",$id_sala);
$stmt->execute();
$res = $stmt->get_result();

while ($m = $res->fetch_assoc()):
    $isMine = ($m['user_id'] == $user_id);
    $cls = $isMine ? 'msg-me' : 'msg-other';
    $avatar = $m['avatar'] ? 'uploads/'.esc($m['avatar']) : null;
    $author = esc($m['nome']);
    $text = esc($m['mensagem']);
    $timeTitle = date('d/m/Y H:i:s', strtotime($m['data']));
    $relative = formatarTempo($m['data']);
    // reactions
    $r = $conexao->prepare("SELECT emoji, COUNT(*) as cnt FROM tb_reacoes WHERE id_msg = ? GROUP BY emoji");
    $r->bind_param("i",$m['id']); $r->execute(); $resr = $r->get_result();
    $reactions = []; while($rr = $resr->fetch_assoc()) $reactions[] = $rr; $r->close();
?>
<div class="msg <?= $cls ?>" data-msgid="<?= $m['id'] ?>" title="<?= $timeTitle ?>">
  <div class="avatar">
    <?php if ($avatar): ?>
      <img src="<?= $avatar ?>" alt="avatar">
    <?php else: ?>
      <?= esc(mb_substr($author,0,1)) ?>
    <?php endif; ?>
  </div>

  <div class="msg-body">
    <div class="msg-head">
      <span class="msg-author"><?= $author ?></span>
      <span class="msg-time"><?= $relative ?></span>
      <?php if ($isMine): ?>
        <span class="msg-actions">
          <button class="btn-edit" data-id="<?= $m['id'] ?>">✏️</button>
          <button class="btn-delete" data-id="<?= $m['id'] ?>">🗑️</button>
        </span>
      <?php endif; ?>
    </div>

    <div class="msg-text"><?= nl2br($text) ?></div>

    <?php if (!empty($m['arquivo'])): 
      $file = esc($m['arquivo']);
      $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
      if (in_array($ext,['png','jpg','jpeg','gif'])): ?>
        <div class="msg-file"><a href="uploads/<?= $file ?>" target="_blank"><img src="uploads/<?= $file ?>" alt="img"></a></div>
      <?php else: ?>
        <div class="msg-file"><a href="uploads/<?= $file ?>" target="_blank">📎 <?= $file ?></a></div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($reactions)): ?>
      <div class="reactions">
        <?php foreach ($reactions as $rc): ?>
          <button class="reaction-btn" data-msgid="<?= $m['id'] ?>" data-emoji="<?= esc($rc['emoji']) ?>">
            <?= esc($rc['emoji']) ?> <span class="cnt"><?= (int)$rc['cnt'] ?></span>
          </button>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</div>
<?php endwhile; $stmt->close(); ?>
