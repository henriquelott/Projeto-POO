<?php
require_once "global.php";

class Secretaria extends Funcionario
{

  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
  }
}


?>