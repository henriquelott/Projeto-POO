<?php
require_once "global.php";

class Desconto_A_Vista extends Calculo_Desconto
{

  public function calcular_desconto(float $valor_total) 
  {
    return 0.0;
  }
}



?>