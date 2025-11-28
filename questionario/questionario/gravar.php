<?php
include('conecta.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  die("<h3 style='color:red;'>Acesso inválido! Envie o formulário.</h3>");
}

// Recebendo os dados
$nome   = $_POST['nome']   ?? '';
$serie  = $_POST['serie']  ?? '';
$email  = $_POST['email']  ?? '';
$cpf    = $_POST['cpf']    ?? '';
$conceito = $_POST['conceito'] ?? '';
$quest2   = $_POST['quest2']   ?? '';
$quest3   = $_POST['quest3']   ?? '';
$quest4   = $_POST['quest4']   ?? '';
$coment_um = $_POST['coment_um'] ?? '';
$tecnologias = $_POST['tecnologias'] ?? '';
$coment_dois = $_POST['coment_dois'] ?? '';
$mascote = $_POST['mascote'] ?? '';
$vf1 = $_POST['vf1'] ?? '';
$vf2 = $_POST['vf2'] ?? '';
$vf3 = $_POST['vf3'] ?? '';
$vf4 = $_POST['vf4'] ?? '';

if (empty($nome) || empty($serie) || empty($email) || empty($cpf)) {
  die("<h3 style='color:red;'>Faltam dados obrigatórios no formulário!</h3>");
}

$query = "INSERT INTO $tabela (
  nome, serie, email, cpf, quest1, quest2, quest3, quest4,
  coment_um, tecnologias, coment_dois, mascote, vf1, vf2, vf3, vf4
) VALUES (
  '$nome', '$serie', '$email', '$cpf',
  '$conceito', '$quest2', '$quest3', '$quest4',
  '$coment_um', '$tecnologias', '$coment_dois', '$mascote',
  '$vf1', '$vf2', '$vf3', '$vf4'
)";

if ($mysqli->query($query)) {
  echo "<h2 style='color:green;'>Questionário enviado com sucesso!</h2>";
} else {
  echo "<h3 style='color:red;'>Erro ao gravar: " . $mysqli->error . "</h3>";
}
$mysqli->close();
?>
