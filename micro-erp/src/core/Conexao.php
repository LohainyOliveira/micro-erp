<?php
class Conexao_database {
    private $host = 'localhost';
    private $dbname = 'micro_erp';
    private $user = 'root';
    private $pass = 'root'; // senha do mysql

    public function getConnection() {
        try {
            $pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
                $this->user,
                $this->pass
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }
}
?>