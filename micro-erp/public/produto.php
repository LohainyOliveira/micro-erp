<?php
require_once '../src/core/conexao.php';
require_once '../src/models/Produto.php';

$db = new Conexao_database();
$pdo = $db->getConnection();
$produto = new Produto($pdo);

$lista = $produto->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estoque</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Cadastro de Produto</h1>
    <form action="estoque.php" method="POST">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="text" name="descricao" placeholder="Descrição">
        <input type="number" name="preco" placeholder="Preço" step="0.01" required>
        <input type="number" name="quantidade" placeholder="Quantidade" required>
        <input type="number" name="ncm" placeholder="NCM" required>
        <input type="number" name="cfop" placeholder="CFOP" required>
        <button type="submit">Salvar</button>
    </form>

    <h2>Produtos Cadastrados</h2>
    <ul>
        <?php foreach ($lista as $p): ?>
            <li><?= $p['nome_prod'] ?> - <?= $p['qtd_prod'] ?> unidades</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
