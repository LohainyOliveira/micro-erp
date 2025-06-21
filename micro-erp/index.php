<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="public/css/login.css" /> <!-- Mantém o design original -->
    <title>Login - Micro-ERP</title>
</head>
<body>
    <div class="container-principal">
        <div class="logo">
            <img src="Img/logo.png" alt="Logo HelpFacul" />
        </div>
    </div>

    <main class="container">
        <!-- Formulário de login que envia para login.php -->
        <form action="src/models/Login.php" method="POST">
            <h1>Login - Micro ERP</h1>

            <div class="input-box">
                <input type="email" name="email" placeholder="Usuário" required />
                <img src="Img/ic_user.png" alt="Ícone usuário" />
            </div>

            <div class="input-box">
                <input type="password" name="senha" placeholder="Senha" required />
                <img src="Img/ic_pass.png" alt="Ícone senha" />
            </div>

            <div class="remenber-forgot">
                <label>
                    <input type="checkbox" />
                    Lembrar senha
                </label>
                <br />
                <a href="public/esqueceu_senha.php">Esqueci minha senha!</a>
            </div>

            <button class="login" type="submit">Login</button>

            <div class="register-link">
                <p>Não tem uma conta? 
                    <a href="public/cadastrar_user.php">Faça seu Cadastro</a> 
                </p>
            </div>
        </form>

        <!-- Exibição de mensagem de erro, caso ?error=1 esteja na URL -->
        <div id="error-message" style="color: white; margin-top: 15px; display: none;">
            Usuário ou senha incorretos. Tente novamente.
        </div>
    </main>

    <!-- Script para detectar parâmetro de erro na URL e mostrar mensagem -->
    <script>
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        window.onload = function () {
            if (getQueryParam('error') === '1') {
                document.getElementById('error-message').style.display = 'block';
            }
        };
    </script>
</body>
</html>
