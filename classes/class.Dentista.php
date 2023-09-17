<?php
  require_once "global.php";

  class Dentista extends Funcionario
  {
    private $cro;
    private $especialidade;
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, $especialidade)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
      
      $this->cro = $cro;
      $this->especialidade = $especialidade;
    }
  }
?>