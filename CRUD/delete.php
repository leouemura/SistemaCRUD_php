<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "../connection.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: ../crud_usuarios.php");
            exit();
        } else{
            echo "Algo aconteceu de errado, por favor, tente mais tarde.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../error.php");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fisioterapia Uemura</title>
    <link rel="stylesheet" href="../css/main_styles.css">
    <link rel="stylesheet" href="../css/delete_styles.css">
</head>
<body>
    <header class="navbar">
        <div class="fisioLogo">Fisioterapia<br>Uemura</div>
        <nav>
            <ul class="nav_ul">
            <?php if (isset($_SESSION['permissao'])){
                if ($_SESSION['permissao']=='adm'){
            ?>
                <li> <a href="../crud_usuarios.php">Clientes</a> </li>
                <li> <a href="#">Acessos Recentes</a> </li>
            <?php 
                }
            }
            ?>
                <li> <a href="../main.php">Home</a> </li>
                <li> <a href="#">Quem Somos</a> </li>
                <li> <a href="#">Contato</a> </li>
                <li> <a href="#">Tratamento</a> </li>

                <li><a id="logOut" href="../fecha_sessao.php">LogOut</a></li>
                
            </ul>
        </nav>
    </header>
    <div class="separator"></div>

    <div class="content">
        <div class="welcome">Deletar Usuário</div>        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p class="red">Você tem certeza de que quer excluir este usuário?</p><br>
                <p class="group_btn">
                    <input type="submit" value="Sim" class="return">
                    <a href="../crud_usuarios.php" class="return">Não</a>
                </p>
            </div>
        </form>
    </div>
</body>
</html>