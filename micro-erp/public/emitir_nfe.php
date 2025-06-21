<?php
require_once '../src/core/conexao.php';
require_once '../src/models/NotaFiscal.php';
require_once '../src/models/Clientes.php';
require_once '../src/models/Produto.php';

$db = new Conexao_database();
$pdo = $db->getConnection();

$notaFiscal = new NotaFiscal($pdo);
$clienteModel = new Cliente($pdo);
$produtoModel = new Produto($pdo);

$mensagem = '';
$clientes = $clienteModel->listar();
$produtos = $produtoModel->listar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_POST['cliente_id'] ?? null;
    $produtos_ids = $_POST['produtos'] ?? [];
    $quantidades = $_POST['quantidades'] ?? [];

    if ($cliente_id && count($produtos_ids) > 0) {
        $itens = [];

        for ($i = 0; $i < count($produtos_ids); $i++) {
            $produto_id = $produtos_ids[$i];
            $quantidade = intval($quantidades[$i]);

            if (!$produto_id || $quantidade < 1) continue;

            // Encontrar o preço do produto selecionado
            $preco = 0;
            foreach ($produtos as $p) {
                if ($p['id_prod'] == $produto_id) {
                    $preco = $p['preco_prod'];
                    break;
                }
            }

            $itens[] = [
                'produto_id' => $produto_id,
                'quantidade' => $quantidade,
                'preco_unitario' => $preco
            ];
        }

        if (count($itens) > 0) {
            try {
                $notaFiscal->emitir($cliente_id, $itens);
                $mensagem = "Nota fiscal emitida com sucesso!";
            } catch (Exception $e) {
                $mensagem = "Erro: " . $e->getMessage();
            }
        } else {
            $mensagem = "Itens inválidos.";
        }
    } else {
        $mensagem = "Preencha todos os campos obrigatórios.";
    }
}

$notas = $notaFiscal->listar();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Emitir Nota Fiscal</title>
    <style>
        .produto-item {
            margin-bottom: 10px;
        }
        .produto-item select, .produto-item input {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h1>Emitir Nota Fiscal</h1>

    <?php if ($mensagem): ?>
        <p style="color: green;"><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Cliente:</label>
        <select name="cliente_id" required>
            <option value="">-- Selecione o Cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id_cli'] ?>"><?= htmlspecialchars($c['nome_cli']) ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Produtos</h3>
        <div id="produtos-container">
            <div class="produto-item">
                <select name="produtos[]" required>
                    <option value="">-- Produto --</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p['id_prod'] ?>"><?= htmlspecialchars($p['nome_prod']) ?> - R$ <?= number_format($p['preco_prod'], 2, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="quantidades[]" min="1" value="1" required />
                <button type="button" onclick="removerProduto(this)">Remover</button>
            </div>
        </div>
        <button type="button" onclick="adicionarProduto()">Adicionar Produto</button>
        <br><br>
        <button type="submit">Emitir Nota Fiscal</button>
    </form>

    <h2>Notas Emitidas</h2>
    <ul>
        <?php foreach ($notas as $n): ?>
            <li>
                <strong><?= htmlspecialchars($n['cliente_nome']) ?></strong> — 
                R$ <?= number_format($n['total_nfe'], 2, ',', '.') ?> —
                <?= date('d/m/Y H:i', strtotime($n['data_emissao_nfe'])) ?> |
                <a href="ver_xml.php?id=<?= $n['id_nfe'] ?>" target="_blank">Ver XML</a> |
                <a href="dowload_xml.php?id=<?= $n['id_nfe'] ?>">Download XML</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <script>
        function adicionarProduto() {
            const container = document.getElementById('produtos-container');
            const item = document.createElement('div');
            item.classList.add('produto-item');
            item.innerHTML = `
                <select name="produtos[]" required>
                    <option value="">-- Produto --</option>
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p['id_prod'] ?>"><?= htmlspecialchars($p['nome_prod']) ?> - R$ <?= number_format($p['preco_prod'], 2, ',', '.') ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="quantidades[]" min="1" value="1" required />
                <button type="button" onclick="removerProduto(this)">Remover</button>
            `;
            container.appendChild(item);
        }

        function removerProduto(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
