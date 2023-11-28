<?php
  require_once "global.php";

/* Declaração de Variáveis */
  $user = @$_REQUEST['user'];
  $pass = @$_REQUEST['pass'];
  $submit = @$_REQUEST['submit'];

  /* Testa se o botão submit foi ativado */
  if($submit)
  {
    if(null == ($user && $pass))
      echo "<script>alert('Por favor, preencha todos os campos!');</script>";
    
    else
    {
      if(Facade::realizar_login($user, $pass))
        header("Location: _painel.php");

      else
        "<script>alert('Usuário e/ou senha inválido(s), Tente novamente!');</script>";
    }

  }
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Sistema de Login :: Toolmmer</title>
    <meta charset="UTF-8" />
    <!-- Estilos da Index.php -->
    <style type="text/css">
    </style>
  </head>
  <body>
      <!-- Aqui temos o formulário
        *Action é vazia por que vamos fazer a validação e o redirecionamento nesta mesma página.
      -->
      <form name="" method="post" action="">
        <label>usuário: <input type="text" name="user" /></label><br /><br />
        <label>senha: <input type="password" name="pass" /></label><br /><br />
        <input type="submit" name="submit" value="entrar" />
      </form>

      <p>
          <a href="_criar_perfil.php">criar perfil</a>
      </p>
  </body>
</html>	