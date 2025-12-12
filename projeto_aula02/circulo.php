<?php

define("PI", 3.14159);

$raio = 5;

$area = PI * ($raio ** 2);

echo "<h2>Atividade 8: Área do Círculo</h2>";

echo "Raio: {$raio} cm <br>";
echo "Área: " . round($area, 2) . " cm²"; // Arredondado para 2 casas decimais

?>
