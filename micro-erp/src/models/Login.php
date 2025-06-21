<?php
session_start();
require_once '../core/Conexao.php'; 

// Instancia a conexão com o banco
$db = new Conexao_database();
$pdo = $db->getConnection();

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (!empty($email) && !empty($senha)) {
        // Busca o usuário pelo e-mail
        $sql = "SELECT * FROM usuarios WHERE email_user = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            
            if (md5($senha) === $usuario['senha_user']) {
                unset($usuario['senha_user']);
                $_SESSION['usuario'] = $usuario;

                
                header('Location: ../../public/dasboard.php');
                exit();
            }
        }


        // E-mail ou senha inválidos
        header('Location: ../../index.php?error=1');
        exit();
    } else {
        // Campos vazios
        header('Location: ../../index.php?error=2');
        exit();
    }
} else {
    // Acesso direto via GET
    header('Location: ../../index.php');
    exit();
}
?>
