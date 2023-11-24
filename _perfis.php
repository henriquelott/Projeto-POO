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

  $perfis = Users::getRecords();

  foreach( $perfis as $perfil )
  {
    echo "<p>" . "Usuário: " . $perfil->login . "</p>";
    echo "<p>" . "E-mail: " . $perfil->email . "</p>";
    echo "<p>" . "Tipo de Perfil: " . $perfil->tipo_perfil . "</p>";
    echo "</br>";
  }

  ?>

    <p>
        <a href="_criar_perfil.php">voltar</a>
    </p>

</body>
</html>