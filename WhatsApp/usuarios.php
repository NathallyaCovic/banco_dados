<?php
require_once "db.php";

// update typing via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['typing'])) {
    $uid = $_SESSION['user_id'] ?? 0;
    $typing = $_POST['typing'] === '1' ? 1 : 0;
    if ($uid) {
        $u = $conexao->prepare("UPDATE tb_usuarios SET digitando = ?, ultimo_acesso = NOW() WHERE id = ?");
        $u->bind_param("ii", $typing, $uid);
        $u->execute();
        $u->close();
    }
    echo json_encode(['ok'=>true]);
    exit;
}

// list users and optionally update last_active for caller
$myId = isset($_GET['user']) ? intval($_GET['user']) : 0;
if ($myId) {
    $conexao->query("UPDATE tb_usuarios SET ultimo_acesso = NOW() WHERE id = ".(int)$myId);
}

$res = $conexao->query("SELECT id,nome,avatar,ultimo_acesso,digitando FROM tb_usuarios ORDER BY nome");
while ($u = $res->fetch_assoc()):
    $online = (time() - strtotime($u['ultimo_acesso']) <= 30);
    $status = $online ? "<span class='dot online'></span> Online" : "<span class='dot offline'></span> Visto ".formatarTempo($u['ultimo_acesso']);
    $typing = $u['digitando'] ? " <em>✍️ digitando...</em>" : "";
    $avatar = $u['avatar'] ? '<img class="mini" src="uploads/'.esc($u['avatar']).'">' : '<div class="mini init">'.esc(mb_substr($u['nome'],0,1)).'</div>';
    echo "<li>$avatar <strong>".esc($u['nome'])."</strong> - $status $typing</li>";
endwhile;
