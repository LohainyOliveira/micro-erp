<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Cadastra um novo usuário (com senha criptografada)
    public function cadastrar($nome, $email, $senha, $tipo = 'usuario') {
        $senhaHash = md5($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (nome_user, email_user, senha_user, tipo_user) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $email, $senhaHash, $tipo]);
    }

    // Verifica login
    public function autenticar($email, $senha) {
        $sql = "SELECT * FROM usuarios WHERE email_user = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha_user'])) {
            return $usuario; // Retorna dados do usuário autenticado
        }

        return false;
    }

    // Busca um usuário por ID
    public function buscarPorId($id_user) {
        $sql = "SELECT * FROM usuarios WHERE id_user = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
