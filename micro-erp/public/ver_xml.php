<?php
require_once '../src/core/conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Nota não especificada.";
    exit;
}

$db = new Conexao_database();
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT xml FROM notas_fiscais WHERE id = ?");
$stmt->execute([$id]);
$xml = $stmt->fetchColumn();

if (!$xml) {
    echo "XML não encontrado.";
    exit;
}

header("Content-Type: application/xml");
echo $xml;
