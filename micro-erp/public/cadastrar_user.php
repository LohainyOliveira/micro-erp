<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro -  Micro-Erp</title>
    <link rel="stylesheet" href="css/cadastro.css">
</head>
<body>

    <div class="cadastro-container">
        <div class="cadastro-box">
            <div class="logo">
                <img src="../img/logo.png" alt="Logo micro-erp">
            </div>
            <h2>Cadastro de Usuário</h2>
            <form action="cadastrar_user.php" method="POST">
                
                <div class="input-group">
                    <label>Nome completo</label>
                    <input type="text" name="nome" required>
                </div>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>

                <div class="input-group">
                    <label>Senha</label>
                    <input type="password" name="senha" required>
                </div>

                <div class="input-group">
                    <label>Tipo de Usuário</label>
                    <select class="input-group" name="tipo" required>
                        <option value="">-- Selecione --</option>
                        <option value="Cliente">Cliente</option>
                        <option value="Administrador">Administrador</option>
                    </select>
                </div>

                <button type="submit">Cadastrar</button>
                <p class="login-voltar">Já tem uma conta? <a href="../index.php">Faça login</a></p>
            </form>
        </div>
    </div>
</body>
</html>
