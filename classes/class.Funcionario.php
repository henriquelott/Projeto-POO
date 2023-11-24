<?php
  require_once "global.php";

  abstract class Funcionario extends Trabalhador
  {
    protected static $local_filename = "Funcionario.txt";
    protected $salario;  


    //$nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, bool $is_funcionario
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, true);
      
      $this->salario = $salario;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
  }
  ?>