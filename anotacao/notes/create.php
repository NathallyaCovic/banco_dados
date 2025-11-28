<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$user = getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $color = $_POST['color'] ?? '#ffffff';
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    if (!empty($title)) {
        $pdo = getDB();
        $stmt = $pdo->prepare("INSERT INTO notes (user_id, title, content, category, color, is_pinned) VALUES (?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user['id'], $title, $content, $category, $color, $is_pinned])) {
            header("Location: index.php");
            exit();
        }
    }
}
?><!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nota - NoteTaking</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="../" class="logo"><i class="fas fa-sticky-note"></i> NoteTaking</a>
                <nav class="nav-links">
                    <span>Bem-vindo(a), <?php echo htmlspecialchars($user['username']); ?></span>
                    <a href="index.php" class="btn btn-secondary">Voltar para Notas</a>
                    <a href="../logout.php" class="btn btn-secondary">Sair</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="form-header">
            <h1>Criar Nova Nota</h1>
        </div>

        <form method="POST" class="note-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="title">Título *</label>
                    <input type="text" id="title" name="title" required 
                           value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="category">Categoria</label>
                    <input type="text" id="category" name="category" list="categories"
                           value="<?php echo isset($_POST['category']) ? htmlspecialchars($_POST['category']) : ''; ?>">
                    <datalist id="categories">
                        <option value="Pessoal">
                        <option value="Trabalho">
                        <option value="Ideias">
                        <option value="Afazeres">
                        <option value="Estudos">
                    </datalist>
                </div>
            </div>

            <div class="form-group">
                <label for="content">Conteúdo</label>
                <textarea id="content" name="content" rows="15" 
                          placeholder="Comece a escrever sua nota aqui..."><?php echo isset($_POST['content']) ? htmlspecialchars($_POST['content']) : ''; ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_pinned" value="1" 
                               <?php echo isset($_POST['is_pinned']) ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                        Fixar esta nota
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Criar Nota
                </button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="../assets/script.js"></script>
</body>
</html>
