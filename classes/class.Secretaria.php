<?php
require_once "global.php";

class Secretaria extends Trabalhador
{
  protected static $local_filename = "Secretaria.txt";
  protected $salario;
  
  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep);
    $this->salario = $salario;
    $this->save();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function get_salario()
  {
    return $this->salario;
  }
}


?>