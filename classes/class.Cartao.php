<?php
require_once "global.php";

class Cartao extends Forma_De_Pagamento
{
  protected static $local_filename = "Cartao.txt";
  protected ?float $taxa_cartao;
  protected int $parcelas;

  function __construct(string $forma_pagamento, int $parcelas = 1)
  {
    parent::__construct($forma_pagamento);
    $this->parcelas = $parcelas;

    var_dump($this);
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function cadastrar_taxa_cartao($valortotal)
  {
    
    if($this->get_forma_pagamento() == "Debito")
    {
      $taxa = 0.03*$valortotal;
    }
    else
    {
      if($this->parcelas <= 3)
      {
        $taxa = 0.04*$valortotal;
      }
      else if($this->parcelas <= 6)
      {
        $taxa = 0.07*$valortotal;
      }
    }
    
    $this->taxa_cartao = $taxa;
  }
  
  public function calcular_valor($valortotal)
    {
      return $valortotal - $this->taxa_cartao; 
    }

  public function get_taxa()
  {
    
    return $this->taxa_cartao;
  }

  public function get_parcelas()
  {
    return $this->parcelas;
  }
}

?>