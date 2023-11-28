<?php 

  $data = new DateTime('2023-10-8 14:00:00');

  echo "\n", $data->format('Y-m-d H:i:s'), "\n";

  $interval = DateInterval::createFromDateString('30 minutes');

  $nova_data = $data->add($interval);

  echo "\n", $nova_data->format('Y-m-d H:i:s'), "\n";


?>