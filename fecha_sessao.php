<?php
  session_start();
  unset($_SESSION['usuario']);
  unset($_SESSION['email']);
  unset($_SESSION['permissao']);
  header("Location: index.php");
?>