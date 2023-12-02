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

  public function cadastrar_taxa(string $tipo_cartao, float $taxa_cartao, ?array $taxas_parcelas = NULL)
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
            throw (new Exception("\nTaxa de débito já cadastrada\n"));
          }
          else
          {
            throw (new Exception("\nCartão de débito não possui taxa\n"));
          }

        break;

        case "Cartão de crédito":
          if(count($taxas_parcelas) <= 6)
          {
            $this->taxas_creditos = $taxas_parcelas;
            $this->save();
          }
          else if (count($taxas_parcelas) > 6)
          {
            throw (new Exception("\nO pagamento so pode ser dividido em até 6 parcelas\n"));
          }
          else if($taxas_pacrelas == NULL)
          {
            throw (new Exception("\nO número de parcelas deve ser especificado\n"));
          }
      }
    }
  }

  public function get_taxas_credito()
  {
    return $this->taxas_credito;
  }

  public function get_taxa_debito()
  {
    return $this->taxa_debito;
  }

}

?>