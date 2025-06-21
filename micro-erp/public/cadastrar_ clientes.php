<?php
require_once '../src/core/conexao.php';
require_once '../src/models/Clientes.php';

$db = new Conexao_database();
$pdo = $db->getConnection();
$cliente = new Cliente($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $cpf_cnpj = $_POST['cpf_cnpj'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';

    if ($nome) {
        $cliente->inserir($nome, $email, $telefone, $endereco, $cpf_cnpj, $cidade, $estado);
        header('Location: clientes.php');
        exit();
    }
}

$clientes = $cliente->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="css/styles_clientes.css">
</head>
<body>

    <div class="painel">
        <h1 class="titulo">Cadastro de Clientes</h1>

        <form method="POST" class="formulario">
            <div class="campo">
                <label>Nome completo*</label>
                <input type="text" name="nome" required>
            </div>

            <div class="campo">
                <label>Email</label>
                <input type="email" name="email">
            </div>

            <div class="campo">
                <label>Telefone</label>
                <input type="text" name="telefone">
            </div>

            <div class="campo">
                <label>Endereço</label>
                <input type="text" name="endereco">
            </div>

            <div class="campo">
                <label>CPF ou CNPJ</label>
                <input type="text" name="cpf_cnpj">
            </div>

            <div class="campo-duplo">
                <div class="campo">
                    <label>Cidade</label>
                    <input type="text" name="cidade">
                </div>

                <div class="campo">
                    <label>Estado</label>
                    <input type="text" name="estado">
                </div>
            </div>

            <button type="submit" class="botao">Cadastrar Cliente</button>
        </form>

        <h2 class="subtitulo">Clientes Cadastrados</h2>
        <ul class="lista-clientes">
            <?php foreach ($clientes as $c): ?>
                <li>
                    <strong><?= htmlspecialchars($c['nome']) ?></strong> — 
                    <?= htmlspecialchars($c['email']) ?> — 
                    <?= htmlspecialchars($c['telefone']) ?>
                    <br><small><?= htmlspecialchars($c['endereco']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>
</html>
