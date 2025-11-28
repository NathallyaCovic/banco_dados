<?php
$pontuacao = "80";
if ($pontuacao >= 90) {
echo "Excelente! Medalha de Ouro.";
} elseif ($pontuacao >= 70 &&  $pontuacao < 90) {
echo "Bom. Medalha de Prata.";
} else {
echo "Pode melhorar. Sem medalha.";
}
?><br><br>

<?php
$status_code = "200";
if ($status_code = 200) {
echo "Conexão OK. Sucesso.";
} elseif ($status_code = 404) {
echo "Erro: Página não encontrada.";
} elseif ($status_code = 500) {
echo "Erro Interno do Servidor.";
} else {
echo "Status desconhecido.";
}
?><br><br>

<?php
$velocidade_atual = "95";
$limite_velocidade = "80";
if ($velocidade_atual <= 80 ) {
echo "Velocidade permitida.";
} elseif ($velocidade_atual <= 90) {
echo "Multa leve.";
} else {
echo "Multa grave. Pontos na carteira.";
}
?><br><br>

<?php
$numero_teste = "2000";
if ($numero_teste % 2 == 0) {
echo "O número ".$numero_teste." é Par.";
} else {
echo "O número ".$numero_teste." é Ímpar.";
}
?><br><br>