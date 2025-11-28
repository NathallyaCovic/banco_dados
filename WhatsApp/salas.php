<?php
require_once "db.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['novaSala'] ?? '');
    if ($nome !== '') {
        $uid = $_SESSION['user_id'] ?? null;
        $stmt = $conexao->prepare("INSERT INTO tb_salas (nome, criada_por) VALUES (?, ?)");
        $stmt->bind_param("si", $nome, $uid);
        $stmt->execute();
        $stmt->close();
    }
    http_response_code(200);
    exit;
}

// listar salas
$res = $conexao->query("SELECT id,nome FROM tb_salas ORDER BY id ASC");
while ($s = $res->fetch_assoc()) {
    echo "<li data-id='".((int)$s['id'])."' class='sala-item'># ".esc($s['nome'])."</li>";
}
?>
