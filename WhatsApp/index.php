<?php
// index.php - login / registro
require_once "db.php";
$errors = [];
$success = null;

// Registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $avatarName = null;

    // basic validation
    if (strlen($nome) < 2) $errors[] = "Nome muito curto.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email inválido.";
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/', $senha)) {
        $errors[] = "Senha deve ter mínimo 8 caracteres, 1 letra maiúscula, 1 número e 1 caractere especial.";
    }

    // check duplicate email
    $stmt = $conexao->prepare("SELECT id FROM tb_usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) $errors[] = "Email já cadastrado.";
    $stmt->close();

    // avatar upload optional
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif'];
        if (!in_array($ext, $allowed)) $errors[] = "Avatar: tipo inválido.";
        if ($_FILES['avatar']['size'] > 2*1024*1024) $errors[] = "Avatar muito grande (máx 2MB).";
        if (empty($errors)) {
            if (!is_dir(__DIR__.'/uploads')) mkdir(__DIR__.'/uploads',0777,true);
            $avatarName = uniqid('avt_') . '.' . $ext;
            move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__.'/uploads/'.$avatarName);
        }
    }

    if (empty($errors)) {
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $ins = $conexao->prepare("INSERT INTO tb_usuarios (nome,email,password_hash,avatar,ultimo_acesso) VALUES (?,?,?,?,NOW())");
        $ins->bind_param("ssss", $nome, $email, $hash, $avatarName);
        if ($ins->execute()) {
            $_SESSION['user_id'] = $conexao->insert_id;
            header("Location: chat.php");
            exit;
        } else {
            $errors[] = "Erro ao criar conta.";
        }
        $ins->close();
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $conexao->prepare("SELECT id, password_hash FROM tb_usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($uid,$hash);
    if ($stmt->fetch()) {
        if (password_verify($senha, $hash)) {
            $_SESSION['user_id'] = $uid;
            $u = $conexao->prepare("UPDATE tb_usuarios SET ultimo_acesso = NOW() WHERE id = ?");
            $u->bind_param("i",$uid);
            $u->execute();
            header("Location: chat.php");
            exit;
        } else {
            $errors[] = "Credenciais inválidas.";
        }
    } else {
        $errors[] = "Credenciais inválidas.";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Entrar - DiscordChat</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body class="login-body">
  <div class="card auth-card">
    <h1 class="brand">DiscordChat</h1>

    <?php if (!empty($errors)): ?>
      <div class="alert"><?php foreach($errors as $e) echo '<div>'.esc($e).'</div>'; ?></div>
    <?php endif; ?>

    <div class="tabs">
      <button id="tab-login" class="tab active">Login</button>
      <button id="tab-register" class="tab">Registrar</button>
    </div>

    <div id="panel-login" class="panel">
      <form method="post">
        <input type="hidden" name="action" value="login">
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button class="btn" type="submit">Entrar</button>
      </form>
    </div>

    <div id="panel-register" class="panel hidden">
      <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="register">
        <input type="text" name="nome" placeholder="Nome de usuário" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha (8+, 1Maius, 1num, 1!@#)" required>
        <label class="small">Avatar (opcional)</label>
        <input type="file" name="avatar" accept="image/*">
        <button class="btn" type="submit">Criar conta</button>
      </form>
    </div>
  </div>

<script>
const tLogin = document.getElementById('tab-login');
const tReg = document.getElementById('tab-register');
const pLogin = document.getElementById('panel-login');
const pReg = document.getElementById('panel-register');

tLogin.addEventListener('click', ()=>{ tLogin.classList.add('active'); tReg.classList.remove('active'); pLogin.classList.remove('hidden'); pReg.classList.add('hidden'); });
tReg.addEventListener('click', ()=>{ tReg.classList.add('active'); tLogin.classList.remove('active'); pReg.classList.remove('hidden'); pLogin.classList.add('hidden'); });
</script>
</body>
</html>
