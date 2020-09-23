<?php session_start();
if(!isset($_SESSION['usuario'])){
    header("Location: ./index.php?erro_login=2");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fisioterapia Uemura</title>
    <link rel="stylesheet" href="./css/main_styles.css">
</head>
<body>
    <header class="navbar">
        <div class="fisioLogo">Fisioterapia<br>Uemura</div>
        <nav>
            <ul class="nav_ul">
            <?php if (isset($_SESSION['permissao'])){
                if ($_SESSION['permissao']=='adm'){
            ?>
                <li> <a href="crud_usuarios.php">Clientes</a> </li>
                <li> <a href="#">Acessos Recentes</a> </li>
            <?php 
                }
            }
            ?>
                <li> <a href="main.php">Home</a> </li>
                <li> <a href="#">Quem Somos</a> </li>
                <li> <a href="#">Contato</a> </li>
                <li> <a href="#">Tratamento</a> </li>

                <li><a id="logOut" href="fecha_sessao.php">LogOut</a></li>
                
            </ul>
        </nav>
    </header>
    <div class="separator"></div>
    <div class="content">
        <div class="welcome">Seja bem-vindo(a) <?php echo $_SESSION['usuario'];?>!!</div>
        <div class="container_img">
            <img class="img1" src="./img/back_pain.png" alt="Sem Fisio">
            <img class="img2" src="./img/strong.svg" alt="Com Fisio">
            <div class="slogan">
                Seu corpo na <br>melhor forma!!!
            </div>
        </div>

    </div>
    
</body>
</html>