<?php
require_once "global.php"

class Desconto_Cartao extends Calculo_Desconto
  {

    public function calcular_desconto(float $valor_total, float $taxa_desconto) 
    {
      return $valor_total * $taxa_desconto;
    }
  }



?>