<?php
session_start();

// Verifica se o usuário está logado; caso contrário, redireciona para a página de login
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php?error=acesso_negado');
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel - Micro-Erp</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <nav>
            <div class="container">
                <img class="logo" src="../Img/logoLetrasBrancas.png" alt="Logo HelpFacul" />
            </div>
            <div class="mobile-menu" aria-label="Menu móvel" role="button" tabindex="0">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
            
        </nav>
    </header>

    <main>
        <section class="hero-section">
            <div class="hero-text">
                <h1>Bem-vindo, <?= htmlspecialchars($usuario['nome_user'] ?? 'usuário') ?>!</h1>
                <p>
                   
                
                </p>
                 </div>
            <div class="hero-image">
                <img src="../Img/logo.png" alt="Imagem ilustrativa do FaculHelp" />
            </div>
        </section>
    </main>

    <script src="js/scrpts-navbar.js"></script>
</body>
</html>
