<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$user = getCurrentUser();
$pdo = getDB();

// Get note data
$note_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM notes WHERE id = ? AND user_id = ?");
$stmt->execute([$note_id, $user['id']]);
$note = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$note) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category']);
    $color = $_POST['color'] ?? '#ffffff';
    $is_pinned = isset($_POST['is_pinned']) ? 1 : 0;

    if (!empty($title)) {
        $stmt = $pdo->prepare("UPDATE notes SET title = ?, content = ?, category = ?, color = ?, is_pinned = ? WHERE id = ? AND user_id = ?");
        
        if ($stmt->execute([$title, $content, $category, $color, $is_pinned, $note_id, $user['id']])) {
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
    <title>Editar Nota - NoteTaking</title>
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
            <h1>Editar Nota</h1>
        </div>

        <form method="POST" class="note-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="title">Título *</label>
                    <input type="text" id="title" name="title" required 
                           value="<?php echo htmlspecialchars($note['title']); ?>">
                </div>

                <div class="form-group">
                    <label for="category">Categoria</label>
                    <input type="text" id="category" name="category" list="categories"
                           value="<?php echo htmlspecialchars($note['category']); ?>">
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
                <textarea id="content" name="content" rows="15"><?php echo htmlspecialchars($note['content']); ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="is_pinned" value="1" 
                               <?php echo $note['is_pinned'] ? 'checked' : ''; ?>>
                        <span class="checkmark"></span>
                        Fixar esta nota
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Nota
                </button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="../assets/script.js"></script>
</body>
</html>
