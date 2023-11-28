<?php 

require_once "global.php";

  $paciente = new Paciente('joao', 'joao@gmail.com', '33467847', '44i404332', '2000-11-12');

  $paciente->save();

  $pacientico = Paciente::getRecordsByField('nome', 'joao');

  $pacientico[0]->save();

  $pacientico[0]->save();

  $pacientico[0]->save();

  $pacientico[0]->save();

  $pacientico[0]->save();

  var_dump($pacientico);


?>