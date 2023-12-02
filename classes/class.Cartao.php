<?php
require_once "global.php";

class Cartao extends Forma_De_Pagamento
{
  protected static $local_filename = "Cartao.txt";
  protected float $taxa_cartao;
  protected ?int $parcelas;

  function __construct(string $forma_pagamento, ?int $parcelas = NULL)
  {
    if($forma_pagamento == "Cartão de Crédito" && $parcelas >=1 && $parcelas <=6)
    {
      parent::__construct($forma_pagamento);
      $this->parcelas = $parcelas;
      $lista = Lista_Taxas_Cartao::getRecords()[0];
      $this->taxa_cartao = $lista->get_taxas_credito()[$parcelas-1];
    }
    else if($forma_pagamento == "Cartão de Débito" && $parcelas == NULL)
    {
      parent::__construct($forma_pagamento);
      $this->parcelas = $parcelas;
      $lista = Lista_Taxas_Cartao::getRecords()[0];
      $this->taxa_cartao = $lista->get_taxa_debito();
    }
    else
    {
      throw (new Exception("Você não pode parcelar um pagamento em cartão de crédito, nem parcelar um cartão de crédito em mais de 6 vezes."));
    }
  }

  static public function getFilename()
  {
    return "Cartao.txt";
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