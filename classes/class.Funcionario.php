<?php
  require_once "global.php";

  abstract class Funcionario extends Trabalhador
  {  
    protected $salario;  
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep);
      
      $this->salario = $salario;
    }
  }
  ?>