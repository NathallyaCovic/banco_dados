<?php

$distancia_km = 350.7;
$litros_consumidos = 32.5; 

$consumo_medio = $distancia_km / $litros_consumidos;

echo "<h2>Desafio: Consumo de Combustível</h2>";

echo "Distância Percorrida: " . $distancia_km . " km <br>";
echo "Litros Consumidos: " . $litros_consumidos . " L <br>";
echo "O Consumo Médio do veículo foi de: " . round($consumo_medio, 2) . " Km/L.";


?>
