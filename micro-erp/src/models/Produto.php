<?php
class Produto {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Listar todos os produtos
    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM produtos ORDER BY nome_prod ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserir novo produto
    public function inserir($nome, $descricao, $preco, $quantidade) {
        $sql = "INSERT INTO produtos (nome_prod, descricao_prod, preco_prod, qtd_prod)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $descricao, $preco, $quantidade]);
    }

    // Buscar produto pelo ID
    public function buscarPorId($id_prod) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id_prod = ?");
        $stmt->execute([$id_prod]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Reduzir estoque após venda
    public function reduzirEstoque($id_prod, $quantidadeVendida) {
        $produto = $this->buscarPorId($id_prod);
        if (!$produto) return false;

        $estoqueAtual = (int)$produto['qtd_prod'];
        if ($estoqueAtual < $quantidadeVendida) return false;

        $novoEstoque = $estoqueAtual - $quantidadeVendida;
        $sql = "UPDATE produtos SET qtd_prod = ? WHERE id_prod = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$novoEstoque, $id_prod]);
    }

    // Aumentar estoque após devolução ou compra
    public function aumentarEstoque($id_prod, $quantidadeEntrada) {
        $produto = $this->buscarPorId($id_prod);
        if (!$produto) return false;

        $estoqueAtual = (int)$produto['qtd_prod'];
        $novoEstoque = $estoqueAtual + $quantidadeEntrada;
        $sql = "UPDATE produtos SET qtd_prod = ? WHERE id_prod = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$novoEstoque, $id_prod]);
    }
}
?>
