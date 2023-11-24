<?php
require_once "global.php"

class Registro_Pagamento extends persist
{
  protected static $local_filename = "Registro_Pagamento.txt";
  private Forma_De_Pagamento $Forma_de_pagamento;
  private $valor_faturado;
  private $impostos;
  private $receita;

  function construct (Forma_De_Pagamento $forma_de_pagamento)
  {
    $this->Forma_De_Pagamento = $forma_de_pagamento;
    $this->calc_valor_faturado();
    $this->impostos = $valor_faturado * 0,2;
    $this->calc_receita();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }
  
  public function calc_valor_faturado()
    {
      $this->valor_faturado = $this->Forma_De_Pagamento->calcular_valor($this->valor_faturado);
    }

  public function calc_receita()
    {
      $this->receita = $this->valor_faturado - $this->impostos;
   }
}

?>