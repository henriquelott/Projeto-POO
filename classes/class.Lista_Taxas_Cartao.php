<?php
require_once "global.php";

class Lista_Taxas_Cartao extends persist
{

  protected array $taxas_credito = array();
  protected float $taxa_debito;

  public function __construct(){}
  public static function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function cadastrar_taxa(string $tipo_cartao, float $taxa_cartao, ?array $num_parcelas = NULL)
  {
    if($tipo_cartao == "Cartão de débito" || $tipo_cartao == "Cartão de crédito")
    {
      switch ($tipo_cartao)
      {
        case "Cartão de débito":
          if($num_parcelas == NULL && empty($this->taxa_debito))
          {
            $this->taxa_debito = $taxa_cartao;
            $this->save();
          }
          else if (!empty($this->taxa_debito))
          {
            throw (new Exception("\nCartão de débito não possui parcelas\n"));
          }
          else
          {
            
          }

        case "Cartão de crédito":
          if($num_parcelas != NULL)
          {
            $this->taxas_credito[] = $taxa_cartao;
            $this->save();
          }
          else
          {
            throw (new Exception("\nDeve ser especificado o numero de parcelas correspondente à taxa\n"));
          }
      }
    }
  }
    
}

?>