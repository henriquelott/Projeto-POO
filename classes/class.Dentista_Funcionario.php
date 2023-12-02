<?php
  require_once "global.php";

  class Dentista_Funcionario extends Dentista
  {
    protected static $local_filename = "Dentista.txt";
    protected float $salario;
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista, float $salario)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidades, $lista);
      $this->salario = $salario;
    }

    static public function getFilename()
    {
      return self::$local_filename;
    }
  }


?>
