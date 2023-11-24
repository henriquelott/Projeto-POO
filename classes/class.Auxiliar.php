<?php
  require_once "global.php";

  class Auxiliar extends Funcionario
  {
    protected static $local_filename = "Auxiliar.txt";
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
  }
?>

