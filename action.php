<?php
    require('connection.php');
    $email = addslashes($_POST['email']);
    $password = addslashes($_POST['password']);

    $sql_string = "SELECT * from users
                    where email = '".$email."'
                    and password = '".md5($password)."'
                  ";

    $result = mysqli_query($conn, $sql_string, MYSQLI_STORE_RESULT);

    if($result)
    {
        $retornou_algo = mysqli_num_rows($result);
        if($retornou_algo!=0){
            $dados=mysqli_fetch_row($result);

            session_start();
            $_SESSION['usuario']=$dados[1]; //segunda coluna da tabela
            $_SESSION['email']=$dados[3];   //quarta coluna da tabela
            $_SESSION['permissao']=$dados[4];//quinta coluna da tabela

            header("Location: ./main.php");
        }
        else
        {
            header("Location:index.php?erro_login=1");
        }
    }
    else die("Erro no comando SQL:".mysqli_error($conn));
?>