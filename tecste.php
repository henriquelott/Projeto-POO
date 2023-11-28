<?php 

require_once "global.php";

  $paciente = new Paciente('joao', 'joao@gmail.com', '33467847', '44i404332', '2000-11-12');

  $pacientico = Paciente::getRecordsByField('nome', 'joao');

  var_dump($pacientico);


?>