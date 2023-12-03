<?php
require_once "global.php"

abstract class Calculo_Desconto extends persist
  {
    
    abstract public function calcular_desconto(float $valor_total, ?float $taxa_desconto = 0.0);
  }


?>