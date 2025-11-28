<?php

include('conecta.php');

?>

<?php

$nome = $_POST['nome'];
$ano = $_POST['ano'];
$email = $_POST['email'];
$cpf = $_POST['cpf'];
$doze_tabuas = $_POST['doze_tabuas'];
$coment_um = $_POST['coment_um'];
$democracia = $_POST['democracia'];
$vassalagem = $_POST['vassalagem'];
$coment_dois = $_POST['coment_dois'];
$mercantilismo = $_POST['mercantilismo'];
$coronelismo = $_POST['coronelismo'];
$coment_tres = $_POST['coment_tres'];

$query = "INSERT INTO $tabela VALUES ('NULL',
'$nome',
'$ano',
'$email',
'$cpf',
'$doze_tabuas',
'$coment_um',
'$democracia',
'$vassalagem',  
'$coment_dois',
'$mercantilismo',
'$coronelismo',
'$coment_tres')";

$mysqli = new mysqli($host, $login, $password, $bd);

if ($mysqli->connect_error) {
 die("Erro na conexão com o banco de dados: " . $mysqli->connect_error);
}

$resultado = $mysqli->query($query);

if ($resultado) {
  echo "Questionário Back-End foi respondido com sucesso.";
} else {
  echo "Erro na consulta: " . $mysqli->error;
}

$mysqli->close(); 
?>





