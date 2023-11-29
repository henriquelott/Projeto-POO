<?php 

require_once "global.php";

  $pacientico = new Paciente('joao', 'joao@gmail.com', '33467847', '441404332', '2000-11-12');

  $pacientico->save();

  $pacienteco = new Paciente('niombre', 'nombre', 'nombre', 'nombre', '2000-11-12');


  function &encontrar_instancia($instancia, bool $eh_cadastro = false)
  {
    $objeto = get_class($instancia);

    $array = $objeto::getRecords();

    foreach ($array as $record)
    {
      if (($record == $instancia) && (!$eh_cadastro))
      {
        return $record;
      }
      else if (($record == $instancia) && ($eh_cadastro))
      {
        throw (new Exception("\n$objeto já cadastrado\n"));
      }
    }

    if(!$eh_cadastro)
    {
      throw (new Exception("\n$objeto não encontrado\n"));
    }
  }

  try
  {
    $paciente = encontrar_instancia($pacientico);
    var_dump($paciente);
    $pacientico->set_nome("Josimar Tog");
    $paciente = encontrar_instancia($pacientico);
    var_dump($paciente);
    $paciente->set_nome("dodoqdaucu");
  }
  catch (Throwable $t)
  {
    echo $t->getMessage();
  }

  var_dump($paciente);


?>