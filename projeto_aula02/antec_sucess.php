<?php

$numero_base = 42;

$antecessor = $numero_base - 1;
$sucessor = $numero_base + 1; 


$media_extrema = ($antecessor + $sucessor) / 2;

echo "<h2>Atividade 9: Antecessor e Sucessor</h2>";

echo "Número Base: {$numero_base} <br>";
echo "Antecessor: {$antecessor} <br>";
echo "Sucessor: {$sucessor} <br>";
echo "Média Extrema: {$media_extrema} (O valor deve ser o número base!)";

?>
