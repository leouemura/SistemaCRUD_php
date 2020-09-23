<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../connection.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM users WHERE user_id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve individual field value
                $name = $row["username"];
                $address = $row["email"];
                $permission = $row["authorization"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: ../error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: ../error.php");
    exit();
}
?>
<?php session_start();
if(!isset($_SESSION['usuario']))
{
    header("Location: ../index.php?erro_login=2");
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Fisioterapia Uemura</title>
    <link rel="stylesheet" href="../css/main_styles.css">
    <link rel="stylesheet" href="../css/read_styles.css">
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
        <div class="welcome">Dados do Usuário</div>
        
        <div class="form_user">
            <div class="form_group">
                <label>Usuário</label>
                <p class="form_php"><?php echo $row["username"]; ?></p>
            </div>
            <div class="form_group">
                <label>E-mail</label>
                <p class="form_php"><?php echo $row["email"]; ?></p>
            </div>
            <div class="form_group">
                <label>Permissão de acesso</label>
                <p class="form_php"><?php echo $row["authorization"]; ?></p>
            </div>
        </div>

        <p><a href="../crud_usuarios.php" class="return">Retornar</a></p>

    </div>
</body>
</html>