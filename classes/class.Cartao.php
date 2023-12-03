<?php
require_once "global.php";

class Cartao extends Forma_De_Pagamento
{
  protected static $local_filename = "Cartao.txt";
  protected float $taxa_cartao;
  protected ?int $parcelas = NULL;

  function __construct(string $forma_pagamento, ?int $parcelas = NULL)
  {
    if($forma_pagamento == "Cartão de crédito" && $parcelas != NULL)
    {
      parent::__construct($forma_pagamento);
      $this->parcelas = $parcelas;
      $lista = Lista_Taxas_Cartao::getRecords();
      $this->taxa_cartao = $lista[count($lista)-1]->get_taxas_credito()[$parcelas-1];
      $this->save();
    }
    else if($forma_pagamento == "Cartão de débito")
    {
      parent::__construct($forma_pagamento);
      $lista = Lista_Taxas_Cartao::getRecords();
      $this->taxa_cartao = $lista[count($lista)-1]->get_taxa_debito();
      $this->save();
    }
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }
  
  public function calcular_valor($valortotal)
  {
    return this->$calculo_desconto->calcular_desconto($valortotal, $this->taxa_cartao); 
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