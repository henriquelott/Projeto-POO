<?php

require_once("global.php");

$lista = Lista_Especialidades::getRecords();

$lista = $lista[count($lista) -1];


try
{
  throw new Exception("gay.zip");
}
catch (Exception $e)
{
  echo $e->getMessage();
}

?>