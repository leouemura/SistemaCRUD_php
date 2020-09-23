<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fisioterapia Uemura</title>
    <link rel="stylesheet" href="./css/index_styles.css">
</head>
<body>
    <div class="content">
        <div class="text">Login</div>
        <form action="action.php" method="post">

            <div class="field">
                <input type="text" name="email" required>
                <label>Email</label>
            </div>

            <div class="field">
                <input type="password" name="password" required>
                <label>Senha</label>
            </div>

            <div class="forgot-pass">  <a href="/remember">Esqueceu a senha?</a>  </div>
            
            <input type="submit" class="buttonSubmit" value="Entrar">
            <div class="signup">Não possui conta?
                <a href="/cadastro">Cadastre-se</a>
            </div>

            <?php
                if(isset($_GET['erro_login']))
                {
                   if ($_GET['erro_login']==1)
                    {
                        echo '<div class="alert no_user" >
                        Usuário não encontrado, por favor, tente novamente.
                        </div>';
                    }
                    else if ($_GET['erro_login']==2)
                    {
                        echo '<div class="alert no_admin" >
                        Para acessar o conteúdo administrativo, faça o login.
                        </div>';
                    }
                }
            ?>

        </form>
    </div>

</body>
</html>