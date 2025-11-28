<?php
$host = "localhost";
$login = "root";
$password = "";
$bd = "questionario";
$tabela = "pesquisa";

$mysqli = new mysqli($host, $login, $password, $bd);

if ($mysqli->connect_error) {
  die("Erro na conexão: " . $mysqli->connect_error);
}
?>
