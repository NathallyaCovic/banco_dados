<?php
require_once "db.php";
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['ok'=>false,'error'=>'not_logged']); exit; }
$user_id = (int)$_SESSION['user_id'];

$stmt = $conexao->prepare("SELECT nome FROM tb_usuarios WHERE id = ?");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$stmt->bind_result($nome);
$stmt->fetch();
$stmt->close();

$action = $_POST['action'] ?? 'send';

if ($action === 'send') {
    $id_sala = (int)($_POST['id_sala'] ?? 1);
    $mensagem = trim($_POST['mensagem'] ?? '');
    $arquivo = null;

    if (!empty($_FILES['arquivo']['name']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION));
        $permitidos = ['png','jpg','jpeg','gif','pdf','mp3'];
        if (in_array($ext,$permitidos) && $_FILES['arquivo']['size'] <= 5*1024*1024) {
            if (!is_dir(__DIR__.'/uploads')) mkdir(__DIR__.'/uploads',0777,true);
            $arquivo = uniqid('file_') . '.' . $ext;
            move_uploaded_file($_FILES['arquivo']['tmp_name'], __DIR__.'/uploads/'.$arquivo);
        } else {
            echo json_encode(['ok'=>false,'error'=>'file_invalid']); exit;
        }
    }

    if ($mensagem !== '' || $arquivo) {
        $ins = $conexao->prepare("INSERT INTO tb_chat (id_sala,user_id,nome,mensagem,arquivo,data) VALUES (?,?,?,?,?,NOW())");
        $ins->bind_param("iisss", $id_sala, $user_id, $nome, $mensagem, $arquivo);
        $ins->execute();
        $ins->close();
    }
    echo json_encode(['ok'=>true]);
    exit;
}

if ($action === 'edit') {
    $msgId = (int)($_POST['msg_id'] ?? 0);
    $text = trim($_POST['mensagem'] ?? '');
    if ($msgId <= 0) { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
    $s = $conexao->prepare("SELECT user_id FROM tb_chat WHERE id = ?");
    $s->bind_param("i",$msgId); $s->execute(); $s->bind_result($owner); if ($s->fetch() && $owner == $user_id) {
        $s->close();
        $u = $conexao->prepare("UPDATE tb_chat SET mensagem = ?, edited_at = NOW() WHERE id = ?");
        $u->bind_param("si",$text,$msgId); $u->execute(); $u->close();
        echo json_encode(['ok'=>true]); exit;
    } else { echo json_encode(['ok'=>false,'error'=>'forbidden']); exit; }
}
echo json_encode(['ok'=>false,'error'=>'unknown']);
