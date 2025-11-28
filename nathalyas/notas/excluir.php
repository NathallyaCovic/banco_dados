<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header("Location: ../login.php");
    exit();
}

$user = getCurrentUser();
$pdo = getDB();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM notes WHERE id = ? AND user_id = ?");
    $stmt->execute([$_GET['id'], $user['id']]);
}

header("Location: index.php");
exit();
?>
