<?php
//include('protect.php');
require_once "global.php";

//cadastro de especialidades
/*
$procedimentos_clinica_geral = array("Limpeza", "Restauração", "Extração Comum");
$clinica_geral = new Especialidade("Clínica Geral", $procedimentos_clinica_geral);
$clinica_geral->save();

$procedimentos_endontia = array("Canal");
$endontia = new Especialidade("Endontia", $procedimentos_endontia);
$endontia->save();

$procedimentos_cirurgia = array("Extração de Siso");
$cirurgia = new Especialidade("Cirurgia", $procedimentos_cirurgia);
$cirurgia->save();

$procedimentos_estetica = array("Clareamento a laser", "Clareamento a moldeira");
$estetica = new Especialidade("Estética", $procedimentos_estetica);
$estetica->save();
*/

if(!isset($_SESSION)) {
 session_start(); 

  $user = $_GET["usuario"];
  $tipo_perfil = $_GET["tipo_perfil"];
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
    Bem vindo ao Painel, <?php echo $user; ?>.

  <?php
    if($tipo_perfil == "Dentista")
    {
      echo('<p> <a href="_agenda.php">agenda</a> </p>');
    }

    else if($tipo_perfil == "Secretaria")
    {
      echo('<p> <a href="_cadastra_paciente.php">cadastrar paciente</a> </p>');
    }
  ?>
    <p>
        <a href="_logout.php">sair</a>
    </p>

</body>
</html>