<?php 

require_once "global.php";

$data = '2000-3-12';
$duracao_minutos = 14000;
$data_inicio = new DateTime($data);
$interval = DateInterval::createFromDateString("$duracao_minutos minutes");
$data_fim = $data_inicio->add($interval);

var_dump($data_fim);

?>