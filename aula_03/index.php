<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aula 03 - Parte II</title>
</head>
<body>
    <h1>PHP - IF / ELSE - Parte II</h1>

    <?php
    echo "<h2>1. Classificador de Pontuação</h2>";

    $pontuacao = 85;

    echo "Pontuação: $pontuacao<br>";

    if ($pontuacao >= 90) {
        echo "Excelente! Medalha de Ouro.<br><br>";
    } elseif ($pontuacao >= 70 && $pontuacao < 90) {
        echo "Bom. Medalha de Prata.<br><br>";
    } else {
        echo "Pode melhorar. Sem medalha.<br><br>";
    }



    echo "<h2>2. Verificador de Status do Servidor</h2>";

    $status_code = 404;

    echo "Status Code: $status_code<br>";

    switch ($status_code) {
        case 200:
            echo "Conexão OK. Sucesso.<br><br>";
            break;

        case 404:
            echo "Erro: Página não encontrada.<br><br>";
            break;

        case 500:
            echo "Erro Interno do Servidor.<br><br>";
            break;

        default:
            echo "Status desconhecido.<br><br>";
    }



    echo "<h2>3. Classificador de Trimestre</h2>";

    $mes = 8;

    echo "Mês: $mes<br>";

    if ($mes >= 1 && $mes <= 3) {
        echo "Primeiro Trimestre.<br><br>";
    } elseif ($mes >= 4 && $mes <= 6) {
        echo "Segundo Trimestre.<br><br>";
    } elseif ($mes >= 7 && $mes <= 9) {
        echo "Terceiro Trimestre.<br><br>";
    } elseif ($mes >= 10 && $mes <= 12) {
        echo "Quarto Trimestre.<br><br>";
    } else {
        echo "Mês inválido.<br><br>";
    }



    echo "<h2>4. Verificador de Velocidade Máxima</h2>";

    $velocidade_atual = 95;
    $limite_velocidade = 80;

    echo "Velocidade atual: $velocidade_atual km/h<br>";
    echo "Limite permitido: $limite_velocidade km/h<br>";

    $diferenca = $velocidade_atual - $limite_velocidade;

    if ($velocidade_atual <= $limite_velocidade) {
        echo "Velocidade permitida.<br><br>";
    } elseif ($diferenca <= 10) {
        echo "Multa leve.<br><br>";
    } else {
        echo "Multa grave. Pontos na carteira.<br><br>";
    }



    echo "<h2>5. Verificador de Par ou Ímpar</h2>";

    $numero_teste = 17;

    echo "Número testado: $numero_teste<br>";

    if ($numero_teste % 2 == 0) {
        echo "O número $numero_teste é Par.<br><br>";
    } else {
        echo "O número $numero_teste é Ímpar.<br><br>";
    }
    ?>

</body>
</html>
