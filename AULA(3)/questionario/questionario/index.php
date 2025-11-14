<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>.::: Questionário de Química :::.</title>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 30px;
  background: #f4f6f7;
}
table {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px #ccc;
}
h2 {
  text-align: center;
  color: #2c3e50;
}
textarea {
  width: 100%;
  border-radius: 6px;
  padding: 6px;
}
input[type="text"], input[type="radio"] {
  margin: 5px 0;
}
hr {
  margin: 20px 0;
}
</style>
</head>

<body>
<form action="gravar.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="900" border="0" align="center">
    <tr>
      <td colspan="3">
        <h2>Questionário de Química</h2>
      </td>
    </tr>

    <!-- DADOS PESSOAIS -->
    <tr><td colspan="3"><hr></td></tr>
    <tr><td>Nome:</td><td><input name="nome" type="text" size="80" required></td></tr>
    <tr><td>Setor:</td><td><input name="setor" type="text" size="80"></td></tr>
    <tr><td>Cargo:</td><td><input name="cargo" type="text" size="80"></td></tr>
    <tr><td>CPF:</td><td><input name="cpf" type="text" size="80"></td></tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- 4 QUESTÕES DE MÚLTIPLA ESCOLHA -->
    <tr><td colspan="3"><b>QUESTÕES DE MÚLTIPLA ESCOLHA</b></td></tr>

    <tr><td colspan="3"><br>1️⃣ O átomo é formado por:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="conceito" value="Núcleo e elétrons"> Núcleo e elétrons</label><br>
        <label><input type="radio" name="conceito" value="Elétrons e prótons apenas"> Elétrons e prótons apenas</label><br>
        <label><input type="radio" name="conceito" value="Moléculas e compostos"> Moléculas e compostos</label><br>
        <label><input type="radio" name="conceito" value="Íons e ligações químicas"> Íons e ligações químicas</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>2️⃣ Qual dessas substâncias é um composto químico?</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest2" value="O₂"> O₂</label><br>
        <label><input type="radio" name="quest2" value="H₂"> H₂</label><br>
        <label><input type="radio" name="quest2" value="H₂O"> H₂O</label><br>
        <label><input type="radio" name="quest2" value="N₂"> N₂</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>3️⃣ O número atômico representa:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest3" value="Soma de prótons e nêutrons"> A soma de prótons e nêutrons</label><br>
        <label><input type="radio" name="quest3" value="Elétrons da camada de valência"> O número de elétrons da camada de valência</label><br>
        <label><input type="radio" name="quest3" value="Prótons no núcleo"> O número de prótons no núcleo</label><br>
        <label><input type="radio" name="quest3" value="Moléculas em um mol"> O número de moléculas em um mol</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>4️⃣ Em uma reação química, ocorre:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest4" value="Criação de novos átomos"> A criação de novos átomos</label><br>
        <label><input type="radio" name="quest4" value="Destruição dos elementos"> A destruição dos elementos originais</label><br>
        <label><input type="radio" name="quest4" value="Reorganização dos átomos"> A reorganização dos átomos formando novas substâncias</label><br>
        <label><input type="radio" name="quest4" value="Transformação de energia em massa"> A transformação de energia em massa</label>
      </td>
    </tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- 4 QUESTÕES DISSERTATIVAS -->
    <tr><td colspan="3"><b>QUESTÕES DISSERTATIVAS</b></td></tr>

    <tr><td colspan="3"><br>5️⃣ Explique a diferença entre elemento químico, substância simples e substância composta, dando exemplos.</td></tr>
    <tr><td colspan="3"><textarea name="coment_um" rows="4"></textarea></td></tr>

    <tr><td colspan="3"><br>6️⃣ Descreva o que é uma ligação iônica e uma ligação covalente, e cite um exemplo de cada uma.</td></tr>
    <tr><td colspan="3"><textarea name="tecnologias" rows="4"></textarea></td></tr>

    <tr><td colspan="3"><br>7️⃣ O que é o pH e como ele indica se uma substância é ácida, neutra ou básica?</td></tr>
    <tr><td colspan="3"><textarea name="coment_dois" rows="4"></textarea></td></tr>

    <tr><td colspan="3"><br>8️⃣ Explique o princípio da Lei da Conservação da Massa proposta por Lavoisier e sua importância nas reações químicas.</td></tr>
    <tr><td colspan="3"><textarea name="mascote" rows="4"></textarea></td></tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- 4 QUESTÕES DE VERDADEIRO OU FALSO -->
    <tr><td colspan="3"><b>QUESTÕES DE VERDADEIRO OU FALSO</b></td></tr>

    <tr><td colspan="3"><br>9️⃣ Na tabela periódica, os metais tendem a perder elétrons e formar cátions.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf1" value="Verdadeiro"> Verdadeiro</label>
        <label><input type="radio" name="vf1" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>🔟 O oxigênio é um exemplo de substância composta.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf2" value="Verdadeiro"> Verdadeiro</label>
        <label><input type="radio" name="vf2" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>1️⃣1️⃣ As reações químicas sempre liberam energia na forma de calor.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf3" value="Verdadeiro"> Verdadeiro</label>
        <label><input type="radio" name="vf3" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>1️⃣2️⃣ A água (H₂O) é uma substância formada por dois elementos químicos diferentes.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf4" value="Verdadeiro"> Verdadeiro</label>
        <label><input type="radio" name="vf4" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- BOTÕES -->
    <tr>
      <td colspan="3" align="center">
        <input type="submit" value=".::: Enviar Questionário :::.">
        <input type="reset" value=".::: Limpar :::.">
      </td>
    </tr>

  </table>
</form>
</body>
</html>
