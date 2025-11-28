<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>.::: Questionário de Química :::.</title>
<style>
  /* ======= ESTILO GERAL ======= */
body {
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #b3e0ff, #e6f7ff);
  margin: 0;
  padding: 0;
}

/* ======= CONTAINER PRINCIPAL ======= */
table {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.15);
  padding: 30px 50px;
  margin: 50px auto;
  max-width: 900px;
  border-collapse: separate;
  border-spacing: 0;
}

/* ======= TÍTULO ======= */
h2 {
  text-align: center;
  color: #005f99;
  margin-bottom: 10px;
}

/* ======= CAMPOS DE TEXTO ======= */
input[type="text"],
input[type="email"],
select,
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  margin-top: 5px;
  font-size: 15px;
  transition: all 0.3s ease;
}

input[type="text"]:focus,
input[type="email"]:focus,
select:focus,
textarea:focus {
  border-color: #007acc;
  box-shadow: 0 0 6px rgba(0, 122, 204, 0.4);
  outline: none;
}

/* ======= SEÇÕES E LINHAS ======= */
td {
  padding: 8px 5px;
  vertical-align: top;
}

hr {
  border: none;
  border-top: 2px solid #007acc33;
  margin: 15px 0;
}

/* ======= RÓTULOS DAS QUESTÕES ======= */
b {
  color: #004d73;
  font-size: 17px;
}

label {
  display: block;
  margin-bottom: 6px;
  cursor: pointer;
}

/* ======= BOTÕES ======= */
input[type="submit"],
input[type="reset"] {
  background-color: #007acc;
  color: white;
  border: none;
  padding: 12px 25px;
  font-size: 16px;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  margin: 10px;
  transition: 0.3s;
}

input[type="reset"] {
  background-color: #555;
}

input[type="submit"]:hover {
  background-color: #005f99;
}

input[type="reset"]:hover {
  background-color: #333;
}

/* ======= TEXTAREA ======= */
textarea {
  resize: vertical;
}

/* ======= RESPONSIVIDADE ======= */
@media (max-width: 768px) {
  table {
    width: 95%;
    padding: 20px;
  }

  input[type="submit"],
  input[type="reset"] {
    width: 100%;
  }
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

    <tr>
      <td>Série:</td>
      <td>
        <select name="serie" required>
          <option value="">Selecione</option>
          <option value="1A">1º Ano A</option>
          <option value="1B">1º Ano B</option>
          <option value="2A">2º Ano A</option>
          <option value="2B">2º Ano B</option>
          <option value="3A">3º Ano A</option>
          <option value="3B">3º Ano B</option>
        </select>
      </td>
    </tr>

    <tr><td>E-mail:</td><td><input name="email" type="email" size="80" required></td></tr>
    <tr><td>CPF:</td><td><input name="cpf" type="text" size="80" required></td></tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- QUESTÕES DE MÚLTIPLA ESCOLHA -->
    <tr><td colspan="3"><b>QUESTÕES DE MÚLTIPLA ESCOLHA</b></td></tr>

    <tr><td colspan="3"><br>01. O átomo é formado por:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="conceito" value="Núcleo e elétrons" required> Núcleo e elétrons</label><br>
        <label><input type="radio" name="conceito" value="Elétrons e prótons apenas"> Elétrons e prótons apenas</label><br>
        <label><input type="radio" name="conceito" value="Moléculas e compostos"> Moléculas e compostos</label><br>
        <label><input type="radio" name="conceito" value="Íons e ligações químicas"> Íons e ligações químicas</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>02. Qual dessas substâncias é um composto químico?</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest2" value="O₂" required> O₂</label><br>
        <label><input type="radio" name="quest2" value="H₂"> H₂</label><br>
        <label><input type="radio" name="quest2" value="H₂O"> H₂O</label><br>
        <label><input type="radio" name="quest2" value="N₂"> N₂</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>03. O número atômico representa:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest3" value="Soma de prótons e nêutrons" required> A soma de prótons e nêutrons</label><br>
        <label><input type="radio" name="quest3" value="Elétrons da camada de valência"> O número de elétrons da camada de valência</label><br>
        <label><input type="radio" name="quest3" value="Prótons no núcleo"> O número de prótons no núcleo</label><br>
        <label><input type="radio" name="quest3" value="Moléculas em um mol"> O número de moléculas em um mol</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>04. Em uma reação química, ocorre:</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="quest4" value="Criação de novos átomos" required> A criação de novos átomos</label><br>
        <label><input type="radio" name="quest4" value="Destruição dos elementos"> A destruição dos elementos originais</label><br>
        <label><input type="radio" name="quest4" value="Reorganização dos átomos"> A reorganização dos átomos formando novas substâncias</label><br>
        <label><input type="radio" name="quest4" value="Transformação de energia em massa"> A transformação de energia em massa</label>
      </td>
    </tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- QUESTÕES DISSERTATIVAS -->
    <tr><td colspan="3"><b>QUESTÕES DISSERTATIVAS</b></td></tr>

    <tr><td colspan="3"><br>05. Explique a diferença entre elemento químico, substância simples e substância composta, dando exemplos.</td></tr>
    <tr><td colspan="3"><textarea name="coment_um" rows="4" required></textarea></td></tr>

    <tr><td colspan="3"><br>06. Descreva o que é uma ligação iônica e uma ligação covalente, e cite um exemplo de cada uma.</td></tr>
    <tr><td colspan="3"><textarea name="tecnologias" rows="4" required></textarea></td></tr>

    <tr><td colspan="3"><br>07. O que é o pH e como ele indica se uma substância é ácida, neutra ou básica?</td></tr>
    <tr><td colspan="3"><textarea name="coment_dois" rows="4" required></textarea></td></tr>

    <tr><td colspan="3"><br>08. Explique o princípio da Lei da Conservação da Massa proposta por Lavoisier e sua importância nas reações químicas.</td></tr>
    <tr><td colspan="3"><textarea name="mascote" rows="4" required></textarea></td></tr>

    <tr><td colspan="3"><hr></td></tr>

    <!-- QUESTÕES DE VERDADEIRO OU FALSO -->
    <tr><td colspan="3"><b>QUESTÕES DE VERDADEIRO OU FALSO</b></td></tr>

    <tr><td colspan="3"><br>09. Na tabela periódica, os metais tendem a perder elétrons e formar cátions.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf1" value="Verdadeiro" required> Verdadeiro</label>
        <label><input type="radio" name="vf1" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>10. O oxigênio é um exemplo de substância composta.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf2" value="Verdadeiro" required> Verdadeiro</label>
        <label><input type="radio" name="vf2" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>11. As reações químicas sempre liberam energia na forma de calor.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf3" value="Verdadeiro" required> Verdadeiro</label>
        <label><input type="radio" name="vf3" value="Falso"> Falso</label>
      </td>
    </tr>

    <tr><td colspan="3"><br>12. A água (H₂O) é uma substância formada por dois elementos químicos diferentes.</td></tr>
    <tr>
      <td colspan="3">
        <label><input type="radio" name="vf4" value="Verdadeiro" required> Verdadeiro</label>
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
