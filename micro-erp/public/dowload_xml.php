<?php
require_once '../src/core/conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID da nota não especificado.");
}

$db = new Conexao_database();
$pdo = $db->getConnection();

$stmt = $pdo->prepare("SELECT xml FROM notas_fiscais WHERE id_nfe = ?");
$stmt->execute([$id]);
$xml = $stmt->fetchColumn();

if (!$xml) {
    die("Nota não encontrada ou XML vazio.");
}

// Limpa qualquer output anterior 
if (ob_get_level()) {
    ob_end_clean();
}

header('Content-Type: application/xml; charset=utf-8');
header("Content-Disposition: attachment; filename=NFE_{$id}.xml");
header('Content-Length: ' . strlen($xml));

echo $xml;
exit;
