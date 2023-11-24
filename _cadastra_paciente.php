<?php
//include('protect.php');

/* Declaração de variáveis */

$submit1 = @$_REQUEST['submit1'];
$submit2 = @$_REQUEST['submit2'];

/* Testa se o botão submit foi ativado */

if($submit1){
  echo "<script>alert('submit1');</script>";
}
else if($submit2){
  echo "<script>alert('submit2');</script>";
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
    Interface de cadastro de PACIENTE.

      <form name="" method="post" action="">
        <p>
        <input type="submit" name="submit1" value="criar orçamento" />
        </p> <p>
        <input type="submit" name="submit2" value="cadastrar paciente" />
        </p>
      </form>

    <p>
        <a href="_painel.php">voltar</a>
    </p>

    <p>
        <a href="_logout.php">Sair</a>
    </p>

</body>
</html>