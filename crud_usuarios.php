<?php session_start();
if(!isset($_SESSION['usuario']))
{
    header("Location: ./index.php?erro_login=2");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fisioterapia Uemura</title>
    <link rel="stylesheet" href="./css/crud_styles.css">
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
        <div class="welcome">Cadastro dos Usuários</div>
        <a href="./CRUD/create.php" class="newUser">Add novo usuário</a>

        <div class="userTable">
            <?php
                require_once "connection.php";
                     
                $sql = "SELECT * FROM users";
                if($result = mysqli_query($conn, $sql)){
                    if(mysqli_num_rows($result) > 0){
                        echo "<table class='table'>";
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>#</th>";
                                    echo "<th>Usuário</th>";
                                    echo "<th>E-mail</th>";
                                    echo "<th>Permissão</th>";
                                    echo "<th>Ação</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($row = mysqli_fetch_array($result)){
                                if($row['authorization']=='adm') $txt_valor="administrativo";
                                if($row['authorization']=='usr') $txt_valor="cliente";
                                
                                echo "<tr>";
                                    echo "<td>" . $row['user_id'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
                                    echo "<td>" . $row['email'] . "</td>";
                                    echo "<td>" . $txt_valor . "</td>";
                                    echo "<td>";
                                        echo "<a href='./CRUD/read.php?id=". $row['user_id'] ."' title='Visualizar'><img class='crud_img' src='./img/read.png'></a>";
                                        echo "<a href='./CRUD/update.php?id=". $row['user_id'] ."' title='Atualizar'><img class='crud_img' src='./img/update.png'></a>";
                                        echo "<a href='./CRUD/delete.php?id=". $row['user_id'] ."' title='Apagar'><img class='crud_img' src='./img/delete.png'></a>";
                                    echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else{
                        echo "<p class='no_register'><em>Nenhum registro encontrado.</em></p>";
                    }
                } else{
                    echo "ERRO: Não foi possível executar o comando $sql. " . mysqli_error($link);
                }

                // Close connection
                mysqli_close($conn);
            ?>
        </div>

    </div>



</body>

</html>
