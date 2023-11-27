<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
</head>
<body>
    Disposição dos PERFIS cadastrados.

    <br/>
    <br/>
    
  <?php
  require_once "global.php";
  //include('protect.php');

  $cadastros = Users::getRecords();

  foreach( $cadastros as $cadastro )
  {
    echo "<p>" . "Usuário: " . $cadastro->login . "</p>";
    echo "<p>" . "E-mail: " . $cadastro->email . "</p>";
    echo "<p>" . "Nome do Perfil: " . $cadastro->get_perfil()->get_nome_perfil() . "</p>";
    echo "</br>";
  }

  ?>

    <p>
        <a href="_criar_perfil.php">voltar</a>
    </p>

</body>
</html>