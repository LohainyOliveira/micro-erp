
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Redefinir Senha</title>
  <link rel="stylesheet" href="css/esquecer.css" />
</head>
<body>

  <div class="cadastro-container">
    <div class="cadastro-box">
      <div class="logo">
        <img src="../img/logo.png" alt="Logo">
      </div>
      <h2>Redefinir Senha</h2>

      <form method="post">
        <div class="input-group">
          <label for="email">E-mail cadastrado</label>
          <input type="email" name="email" placeholder="exemplo@facul.com" required>
        </div>

        <button type="submit">Redefinir Senha</button>
      </form>

      <?= $mensagem ?>

      <div class="login-voltar">
        <a href="../index.php">Voltar para o login</a>
      </div>
    </div>
  </div>

</body>
</html>
