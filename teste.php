<?php

require_once("global.php");

$lista = Lista_Especialidades::getRecords();

$lista = $lista[count($lista) -1];

unset($lista);
var_dump($lista);

?>