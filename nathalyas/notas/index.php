<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$user = getCurrentUser();
$pdo = getDB();

// Handle search and filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';

// Build query
$query = "SELECT * FROM notes WHERE user_id = ?";
$params = [$user['id']];

if (!empty($search)) {
    $query .= " AND (title LIKE ? OR content LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($category)) {
    $query .= " AND category = ?";
    $params[] = $category;
}

$query .= " ORDER BY is_pinned DESC, updated_at DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get categories for filter
$category_stmt = $pdo->prepare("SELECT DISTINCT category FROM notes WHERE user_id = ? AND category IS NOT NULL");
$category_stmt->execute([$user['id']]);
$categories = $category_stmt->fetchAll(PDO::FETCH_COLUMN);
?><!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Notas - NoteTaking</title>
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
                    <a href="criar.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nova Nota
                    </a>
                    <a href="../logout.php" class="btn btn-secondary">Sair</a>
                </nav>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="dashboard-header">
            <h1>Minhas Notas</h1>
        </div>

        <!-- Search and Filter -->
        <div class="filters">
            <form method="GET" class="search-form">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Buscar notas..." 
                           value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fas fa-search"></i></button>
                </div>
                
                <select name="category" onchange="this.form.submit()">
                    <option value="">Todas as Categorias</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?php echo htmlspecialchars($cat); ?>" 
                                <?php echo $category == $cat ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <?php if (!empty($search) || !empty($category)): ?>
                    <a href="index.php" class="btn btn-secondary">Limpar Filtros</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Notes Grid -->
        <div class="notes-grid">
            <?php if (empty($notes)): ?>
                <div class="empty-state">
                    <i class="fas fa-sticky-note"></i>
                    <h3>Nenhuma nota encontrada</h3>
                    <p><?php echo empty($search) ? 'Crie sua primeira nota para começar!' : 'Tente ajustar sua busca ou filtros.'; ?></p>
                    <?php if (empty($search)): ?>
                        <a href="create.php" class="btn btn-primary">Criar Nota</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <?php foreach ($notes as $note): ?>
                    <div class="note-card" style="background-color: <?php echo $note['color']; ?>">
                        <?php if ($note['is_pinned']): ?>
                            <div class="note-pinned"><i class="fas fa-thumbtack"></i></div>
                        <?php endif; ?>
                        
                        <div class="note-header">
                            <h3><?php echo htmlspecialchars($note['title']); ?></h3>
                            <div class="note-actions">
                                <a href="ver.php?id=<?php echo $note['id']; ?>" class="btn-icon" title="Ver">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="edit.php?id=<?php echo $note['id']; ?>" class="btn-icon" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="excluir.php?id=<?php echo $note['id']; ?>" 
                                   class="btn-icon btn-danger" title="Excluir" 
                                   onclick="return confirm('Tem certeza que deseja excluir?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <div class="note-content">
                            <?php echo nl2br(htmlspecialchars(substr($note['content'], 0, 200))); ?>
                            <?php if (strlen($note['content']) > 200): ?>...<?php endif; ?>
                        </div>

                        <?php if (!empty($note['category'])): ?>
                            <div class="note-category">
                                <span class="category-tag"><?php echo htmlspecialchars($note['category']); ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="note-footer">
                            <small>Atualizada em: 
                                <?php echo date('d/m/Y H:i', strtotime($note['updated_at'])); ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="../assets/script.js"></script>
</body>
</html>
