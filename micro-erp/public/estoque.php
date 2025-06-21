<?php
require_once '../src/core/conexao.php';
require_once '../src/models/Produto.php';

$db = new Conexao_database();
$pdo = $db->getConnection();
$produto = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $ncm = $_POST['ncm'];
    $cfop = $_POST['cfop'];

    $produto->inserir($nome, $descricao, $preco, $quantidade, $ncm, $cfop);
}

header("Location: produto.php");
exit();