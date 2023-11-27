<?php
require_once "global.php";

if(!isset($_SESSION)) {
   session_start();
}

/* Declaração de variáveis */

$submit1 = @$_REQUEST['submit1'];
$user = @$_REQUEST['user'];
$pass = @$_REQUEST['pass'];
$email = @$_REQUEST['email'];
//$perfil = @$_REQUEST['perfil'];

if($submit1) {
  if(null != ($user && $pass && $email))
    {
      $nome_usuario = Users::getRecordsByField("usuario", $user);
      if($nome_usuario != null)
      {
        echo "<script>alert('Nome de usuário já existe!');</script>";
      }
    
      else
      {
        $lista_funcionalidades = array('Criar perfil');
        $perfil = new Perfil('admin', $lista_funcionalidades);
        $users = new Users($user, $pass, $email, $perfil);
        $users->save();

        echo "<script>alert('Perfil criado com sucesso!');</script>";
      }
    
  }
  else {
    echo "<script>alert('Preencha todos os campos!');</script>";    
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
</head>
<body>
    Interface de criação de PERFIL.

    <br/>
    <br/>
    <form name="" method="post" action="">
      <label>Usuário: <input type="text" name="user" /></label><br /><br />
      <label>Senha: <input type="password" name="pass" /></label><br /><br />
      <label>E-mail: <input type="email" name="email" /></label><br /><br />
      <label>Tipo de Perfil: <select name="tipo_perfil">
        <option value="Dentista">Dentista</option>
        <option value="Secretaria">Secretária</option>
      </select> </label><br /><br />
      <input type="submit" name="submit1" value="enviar" /></label><br /><br />
    </form>

    <p>
        <a href="_perfis.php">ver perfis</a>
    </p>
    <p>
        <a href="index.php">voltar</a>
    </p>

</body>
</html>