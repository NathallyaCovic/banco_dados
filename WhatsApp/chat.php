<?php
// chat.php - principal
require_once "db.php";
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$user_id = (int)$_SESSION['user_id'];
$stmt = $conexao->prepare("SELECT nome,avatar FROM tb_usuarios WHERE id = ?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$stmt->bind_result($nome,$avatar);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Chat - <?= esc($nome) ?></title>
<link rel="stylesheet" href="estilos.css">
<script src="https://cdn.jsdelivr.net/npm/@joeattardi/emoji-button@5.2.1/dist/index.min.js"></script>
</head>
<body class="chat-body">
  <header class="header">
    <div class="brand">
      <h2>DiscordChat</h2>
    </div>
    <div class="user-mini">
      <img src="<?= $avatar ? 'uploads/'.esc($avatar) : 'default-avatar.png' ?>" alt="avatar" class="mini-avatar">
      <span><?= esc($nome) ?></span>
      <form method="post" action="logout.php" style="display:inline;margin-left:12px;">
        <button class="small-btn" type="submit">Sair</button>
      </form>
    </div>
  </header>

  <div class="container">
    <aside class="sidebar">
      <h3>Salas</h3>
      <ul id="lista-salas"></ul>
      <button id="nova-sala" class="btn-outline">+ Criar Sala</button>
    </aside>

    <aside class="users-col">
      <h3>Usuários</h3>
      <ul id="lista-usuarios"></ul>
    </aside>

    <main class="chat-area">
      <div id="chat-box" class="chat-box"></div>
      <div id="digitando" class="typing"></div>

      <form id="formChat" enctype="multipart/form-data" class="composer">
        <input type="hidden" id="id_sala" name="id_sala" value="1">
        <button type="button" id="emoji-btn" class="icon-btn">😄</button>
        <input type="text" id="mensagem" name="mensagem" autocomplete="off" placeholder="Digite uma mensagem...">
        <label for="arquivo" class="icon-btn">📎</label>
        <input type="file" id="arquivo" name="arquivo" hidden accept=".png,.jpg,.jpeg,.gif,.pdf,.mp3">
        <button type="submit" class="btn">Enviar</button>
      </form>
    </main>
  </div>

  <audio id="beep" src="beep.mp3" preload="auto"></audio>
  <audio id="newmsg" src="newmsg.mp3" preload="auto"></audio>

<script>
const userID = <?= $user_id ?>;
const userName = <?= json_encode($nome) ?>;
</script>
<script src="scripts.js"></script>
</body>
</html>
