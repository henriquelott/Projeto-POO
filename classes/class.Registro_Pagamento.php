<?php
require_once "global.php";

class Registro_Pagamento extends persist
{
  protected static $local_filename = "Registro_Pagamento.txt";
  protected array $forma_de_pagamento;
  protected $valor_faturado;
  protected $impostos;
  protected $receita;
  protected Data $data_pagamento;

  function construct (array $forma_de_pagamento, float $valor_total)
  {
    $this->forma_de_pagamento = $forma_de_pagamento;
    $this->valor_faturado = $valor_total;
    $this->impostos = $this->valor_faturado * 0.2;
    $this->calc_receita();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function calc_receita()
  {
    $this->receita = $this->valor_faturado - $this->impostos;

    foreach($this->forma_de_pagamento as $forma_de_pagamento => $porcentagem)
    {
      $this->receita -= $forma_de_pagamento->calcular_valor($this->valor_faturado * $porcentagem);
    }
  }

  public function get_receita()
  {
    return $this->receita;
  }
}

?>