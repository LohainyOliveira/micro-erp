<?php
class Cliente {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lista todos os clientes
    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM clientes ORDER BY nome_cli ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insere novo cliente
    public function inserir($nome, $email, $telefone, $endereco, $cpf_cnpj) {
        $sql = "INSERT INTO clientes 
                (nome_cli, email_cli, telefone_cli, endereco_cli, cpf_cnpj_cli) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $telefone, $endereco, $cpf_cnpj]);
    }

    // Busca cliente por ID
    public function buscarPorId($id_cli) {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id_cli = ?");
        $stmt->execute([$id_cli]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
