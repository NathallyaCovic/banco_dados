<?php
include('conecta.php');

// Recebendo os dados do formulário
$nome = $_POST['nome'];
$setor = $_POST['setor'];
$cargo = $_POST['cargo'];
$cpf = $_POST['cpf'];

// Questões de múltipla escolha
$conceito = $_POST['conceito'];  // Questão 1
$quest2 = $_POST['quest2'];      // Questão 2
$quest3 = $_POST['quest3'];      // Questão 3
$quest4 = $_POST['quest4'];      // Questão 4

// Questões dissertativas
$coment_um = $_POST['coment_um']; // Questão 5
$tecnologias = $_POST['tecnologias']; // Questão 6
$coment_dois = $_POST['coment_dois']; // Questão 7
$mascote = $_POST['mascote']; // Questão 8

// Questões de Verdadeiro ou Falso
$vf1 = $_POST['vf1']; 
$vf2 = $_POST['vf2'];
$vf3 = $_POST['vf3'];
$vf4 = $_POST['vf4'];

// Características gerais (comentário final)
$caracteristicas = $_POST['caracteristicas'];

// Criar a query de inserção (ajustada com todas as colunas)
$query = "INSERT INTO $tabela 
(nome, setor, cargo, cpf, conceito, coment_um, tecnologias, funcionalidades, coment_dois, mascote, caracteristicas) 
VALUES (
'$nome',
'$setor',
'$cargo',
'$cpf',
'$conceito',
'$coment_um',
'$tecnologias',
'$quest2',
'$coment_dois',
'$mascote',
'$caracteristicas'
)";

$mysqli = new mysqli($host, $login, $password, $bd);

if ($mysqli->connect_error) {
  die('Erro na conexão com o banco de dados: ' . $mysqli->connect_error);
}

$resultado = $mysqli->query($query);

if ($resultado) {
  echo "<h2>Questionário de Química foi enviado com sucesso!</h2>";
} else {
  echo "Erro na consulta: " . $mysqli->error;
}

$mysqli->close();
?>
