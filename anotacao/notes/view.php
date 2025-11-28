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
?><!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($note['title']); ?> - NoteTaking</title>
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
                    <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn btn-primary">Editar</a>
                    <a href="index.php" class="btn btn-secondary">Voltar para Notas</a>
                    <a href="../logout.php" class="btn btn-secondary">Sair</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <article class="note-view" style="background-color: <?php echo $note['color']; ?>">
            <?php if ($note['is_pinned']): ?>
                <div class="note-pinned"><i class="fas fa-thumbtack"></i> Fixada</div>
            <?php endif; ?>
            
            <header class="note-view-header">
                <h1><?php echo htmlspecialchars($note['title']); ?></h1>
                <div class="note-meta">
                    <?php if (!empty($note['category'])): ?>
                        <span class="category-tag"><?php echo htmlspecialchars($note['category']); ?></span>
                    <?php endif; ?>
                    <span class="note-date">
                        Criada: <?php echo date('d/m/Y H:i', strtotime($note['created_at'])); ?>
                        <?php if ($note['created_at'] != $note['updated_at']): ?>
                            <br>Atualizada: <?php echo date('d/m/Y H:i', strtotime($note['updated_at'])); ?>
                        <?php endif; ?>
                    </span>
                </div>
            </header>

            <div class="note-view-content">
                <?php echo nl2br(htmlspecialchars($note['content'])); ?>
            </div>

            <div class="note-view-actions">
                <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Editar Nota
                </a>
                <a href="index.php" class="btn btn-secondary">Voltar para Notas</a>
            </div>
        </article>
    </div>

    <script src="../assets/script.js"></script>
</body>
</html>
