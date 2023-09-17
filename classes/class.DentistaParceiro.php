<?php

require_once "global.php";

class DentistaParceiro extends Trabalhador 
{
  private $cro;
  ptivate $especialidade;
  private $numProcedimentos;
  private $precoConsulta;
  private $taxaComissao;
  
  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidade, $precoConsulta, $taxaComissao)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
    
    $this->cro = $cro;
    $this->especialidade = $especialidade;
    $this->numProcedimentos = 0;
    $this->precoConsulta = $precoConsulta;
    $this->taxaComissao = $taxaComissao;
  }

  public function calcComissao($numProcedimentos, $precoConsulta, $taxaComissao)
  {
    return ($taxaComissao * $precoConsulta * $numProcedimentos);
  }
}

?>