<?php

require_once "global.php";

class Cliente extends Pessoa
{
  protected static $local_filename = "Cliente.txt";
  private $rg;
  private $cpf;
  
  function __construct($nome, $email, $telefone, $rg, $cpf)
  {
    parent::__construct($nome, $email, $telefone);
    
    $this->rg = $rg;
    $this->cpf = $cpf;
    $this->save();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function pagar($valor_total)
  {

  }

  public function getRG()
  {
    return $this->rg;
  }

  public function getCPF()
  {
    return $this->cpf;
  }
}

?>