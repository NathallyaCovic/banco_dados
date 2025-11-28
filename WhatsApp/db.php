<?php
// db.php
session_start();

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'Whatsapp';

$conexao = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}
$conexao->set_charset("utf8mb4");

// escape para saída HTML
function esc($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function formatarTempo($data) {
    if (!$data) return '';
    $agora = new DateTime();
    $d = new DateTime($data);
    $diff = $agora->getTimestamp() - $d->getTimestamp();
    if ($diff < 10) return "agora mesmo";
    if ($diff < 60) return $diff . "s";
    if ($diff < 3600) return "há " . floor($diff/60) . " min";
    if ($diff < 86400) return "há " . floor($diff/3600) . " h";
    return $d->format("d/m H:i");
}
?>
