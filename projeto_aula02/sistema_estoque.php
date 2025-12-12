<?php

$nome_projeto = "Sistema de Estoque";
$versao = 1.1;                       
$data_atual = "20/11/2025";          
$autor = "Dev Back-End Júnior";    

// Montagem da mensagem usando interpolação
$cabecalho = "
<h2>Relatório de Versão</h2>

<p>Projeto: <strong>{$nome_projeto}</strong></p>

<p>Versão: {$versao} | Status em: {$data_atual}</p>

<p>Desenvolvido por: {$autor}</p>
";

echo "<h2>Atividade 10: Multi-Concatenação</h2>";
echo $cabecalho;

?>
