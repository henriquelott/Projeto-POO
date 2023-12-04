<?php
require_once "global.php";

class Lista_Taxas_Cartao extends persist
{
  protected static $local_filename = "Lista_Taxas_Cartao.txt";
  protected array $taxas_credito = array();
  protected float $taxa_debito;

  public function __construct(float $taxa_debito, array $taxas_credito)
  {
    $this->taxas_credito = $taxas_credito;
    $this->taxa_debito = $taxa_debito;
    $this->save();
  }
  public static function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function cadastrar_taxa(float $taxa_debito, array $taxas_credito)
  {
    if(!empty($taxa_debito) && !empty($taxas_credito))
    {
      $this->taxa_debito = $taxa_debito;
      $this->taxas_credito = $taxas_credito;
      $this->save();
    }
    else
    {
      throw (new Exception("\nDevem ser informadas as taxas de cartão crédito e de débito\n"));
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