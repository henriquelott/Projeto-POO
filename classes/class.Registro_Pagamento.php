<?php
require_once "global.php";

class Registro_Pagamento extends persist
{
  protected static $local_filename = "Registro_Pagamento.txt";
  protected array $forma_de_pagamento;
  protected Cliente $cliente;
  protected $valor_faturado;
  protected $impostos;
  protected $receita = 0;
  protected Data $data_pagamento;

  function __construct(array $forma_de_pagamento, float $valor_total, Cliente &$cliente)
  {
    $this->forma_de_pagamento = $forma_de_pagamento;
    $this->valor_faturado = $valor_total;
    $this->impostos = $this->valor_faturado * 0.2;
    $this->cliente = $cliente;
    $this->calc_receita();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function calc_receita()
  {
    $this->receita = $this->valor_faturado - $this->impostos;

    if(count($this->forma_de_pagamento) == 1)
    {
      $this->receita -= $this->forma_de_pagamento[0]->calcular_valor($this->valor_faturado);
    }
    else
    {
      foreach($this->forma_de_pagamento as $iterador)
      {   
        $this->receita -= $iterador[0]->calcular_valor($this->valor_faturado)*$iterador[1];
      }
    }
    $this->save();
  }

  public function get_receita()
  {
    return $this->receita;
  }

  public function get_valor_faturado()
  {
    return $this->valor_faturado;
  }
}

?>