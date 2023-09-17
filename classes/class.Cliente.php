<?php

require_once "global.php";

class Cliente extends Pessoa
{
  private $rg;
  private $cpf;
  
  function __construct($nome, $email, $telefone, $rg, $cpf)
  {
    parent::__construct($nome, $email, $telefone);
    
    $this->rg = $rg;
    $this->cpf = $cpf;
  }

  public function pagar()
  {
    
  }
}

?>