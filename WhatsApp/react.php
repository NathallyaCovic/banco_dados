<?php
require_once "db.php";
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['user_id'])) { echo json_encode(['ok'=>false]); exit; }
$user_id = (int)$_SESSION['user_id'];
$id_msg = (int)($_POST['msg_id'] ?? 0);
$emoji = trim($_POST['emoji'] ?? '');
if ($id_msg <= 0 || $emoji === '') { echo json_encode(['ok'=>false]); exit; }

// check existing
$stmt = $conexao->prepare("SELECT id FROM tb_reacoes WHERE id_msg = ? AND user_id = ? AND emoji = ?");
$stmt->bind_param("iis",$id_msg,$user_id,$emoji);
$stmt->execute(); $stmt->store_result();
if ($stmt->num_rows > 0) {
    // remove
    $stmt->bind_result($rid); $stmt->fetch();
    $del = $conexao->prepare("DELETE FROM tb_reacoes WHERE id = ?");
    $del->bind_param("i",$rid); $del->execute();
    echo json_encode(['ok'=>true,'action'=>'removed']);
} else {
    $ins = $conexao->prepare("INSERT INTO tb_reacoes (id_msg,user_id,emoji) VALUES (?,?,?)");
    $ins->bind_param("iis",$id_msg,$user_id,$emoji); $ins->execute();
    echo json_encode(['ok'=>true,'action'=>'added']);
}
