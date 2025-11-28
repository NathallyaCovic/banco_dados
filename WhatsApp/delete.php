<?php
require_once "db.php";
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['ok'=>false]); exit; }
$user_id = (int)$_SESSION['user_id'];
$msgId = (int)($_POST['msg_id'] ?? 0);
if ($msgId <= 0) { echo json_encode(['ok'=>false]); exit; }
$s = $conexao->prepare("SELECT user_id FROM tb_chat WHERE id = ?");
$s->bind_param("i",$msgId); $s->execute(); $s->bind_result($owner);
if ($s->fetch() && $owner == $user_id) {
    $s->close();
    $u = $conexao->prepare("UPDATE tb_chat SET mensagem = '[Mensagem removida]', deleted = 1 WHERE id = ?");
    $u->bind_param("i",$msgId); $u->execute(); $u->close();
    echo json_encode(['ok'=>true]); exit;
} else {
    echo json_encode(['ok'=>false,'error'=>'forbidden']); exit;
}
