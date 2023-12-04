<?php
require_once "global.php";

abstract class Calculo_Desconto
{
  protected float $valor_total;
  protected ?float $taxa_desconto = NULL;

  public function __construct(float $valor_total, ?float $taxa_desconto = NULL)
  {
    $this->valor_total = $valor_total;
    $this->taxa_desconto = $taxa_desconto;
  }
  abstract public function calcular_desconto();
}


?>