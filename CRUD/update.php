<?php
require_once "../connection.php";;
 
$usuario = $email = $senha = $permissao = "";
$usuario_err = $email_err = $senha_err = $permissao_err = "";
 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate user
    $input_usuario = trim($_POST["usuario"]);
    if(empty($input_usuario)){
        $usuario_err = "Por favor, preencha um usuário válido.";
    } elseif(!filter_var($input_usuario, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z0-9_.-]*$/")))){
        $usuario_err = "Por favor, preencha um usuário válido, somente letras e números.";
    } else{
        $usuario = $input_usuario;
    }
    
    // Validate eletronic mail address
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Por favor, preencha um email válido.";     
    } else{
        $email = $input_email;
    }
    
    // Validate password
    $input_senha = trim($_POST["senha"]);
    $input_senha_conf = trim($_POST["senha_conf"]);
    if(empty($input_senha)){
        $senha_err = "Por favor, preencha uma senha.";     
    } else if(empty($input_senha_conf)){
        $senha_err = "Por favor, preencha uma senha na confirmação.";     
    } else if ($input_senha<>$input_senha_conf) {
        $senha_err = "A senha deve conferir com a confirmação.";  
    } else {
        $senha = $input_senha;
        $senha_conf = $input_senha_conf;
    }

    $input_permissao = trim($_POST["permissao"]);
    $permissao=$input_permissao;

    // Check input errors before inserting in database
    if(empty($usuario_err) && empty($email_err) && empty($senha_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET username=?, email=?, password=MD5(?), authorization=? WHERE user_id=?";
         
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssi", $param_usuario, $param_email, $param_senha, $param_permissao, $param_id);
            
            // Set parameters
            $param_usuario = $usuario;
            $param_email = $email;
            $param_senha = $senha;
            $param_permissao = $permissao;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ../crud_usuarios.php");
                exit();
            } else{
                echo "Algo deu erro, por favor, tente novamente mais tarde.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE user_id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $usuario = $row["username"];
                    $email = $row["email"];
                    $permissao = $row["authorization"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: ../error.php");
                    exit();
                }
                
            } else{
                echo "Algo deu errado, por favor, tente mais tarde.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: ../error.php");
        exit();
    }
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
    <link rel="stylesheet" href="../css/update_styles.css">
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
        <div class="welcome">Atualização Cadastral</div>        
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form_group <?php echo (!empty($usuario_err)) ? 'has-error' : ''; ?>">
                            <label>Name</label>
                            <input type="text" name="usuario" class="form-control" value="<?php echo $usuario; ?>">
                            <span class="help-block"><?php echo $usuario_err;?></span>
                        </div>
                        <div class="form_group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                            <label>E-mail</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="help-block"><?php echo $email_err;?></span>
                        </div>                        
                        <div class="form_group <?php echo (!empty($senha_err)) ? 'has-error' : ''; ?>">
                            <label>Senha</label>
                            <input type="password" name="senha" class="form-control" value="">
                            <span class="help-block"><?php echo $senha_err;?></span>
                        </div>
                        <div class="form_group <?php echo (!empty($senha_err)) ? 'has-error' : ''; ?>">
                            <label>Confirmar senha</label>
                            <input type="password" name="senha_conf" class="form-control" value="">
                            <span class="help-block"><?php echo $senha_err;?></span>
                        </div>
                        <div class="form_group">
                            <label>Permissão</label>
                            <select name="permissao">
                                <option value="adm" <?php if($permissao=='adm') echo 'selected'; ?>>Administrativo</option>
                                <option value="usr" <?php if($permissao=='usr') echo 'selected'; ?>>Cliente</option>
                            </select>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>

                        <div class="group_btn">
                            <input type="submit" class="return" value="Salvar">
                            <p><a href="../crud_usuarios.php" class="return">Cancelar</a></p>
                        </div>
            </form>
        

    </div>
</body>
</html>