<?php
require_once "global.php";

abstract class Calculo_Desconto
{
  abstract public function calcular_desconto(float $valor_total, ?float $taxa_desconto = 0.0);
}


?>