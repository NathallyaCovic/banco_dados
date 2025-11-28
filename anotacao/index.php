<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NoteTaking - Organize Seus Pensamentos</title>
    <link rel="stylesheet" href="assets/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="landing-page">
    <div class="container">
        <header class="hero">
            <h1 class="logo"><i class="fas fa-sticky-note"></i> NoteTaking</h1>
            <p class="tagline">Sua solução simples e bonita para anotações</p>
        </header>

        <main class="hero-content">
            <div class="features-grid">
                <div class="feature-card">
                    <i class="fas fa-edit"></i>
                    <h3>Escrita Fácil</h3>
                    <p>Crie notas com uma interface limpa e sem distrações</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-tags"></i>
                    <h3>Categorias</h3>
                    <p>Organize suas notas com categorias</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-palette"></i>
                    <h3>Cores</h3>
                    <p>Classifique suas notas por cores para melhor organização</p>
                </div>
                <div class="feature-card">
                    <i class="fas fa-search"></i>
                    <h3>Busca Rápida</h3>
                    <p>Encontre suas notas instantaneamente</p>
                </div>
            </div>

            <div class="auth-buttons">
                <a href="login.php" class="btn btn-primary">Começar Agora</a>
                <a href="login.php" class="btn btn-secondary">Entrar</a>
            </div>
        </main>
    </div>
</body>
</html>
