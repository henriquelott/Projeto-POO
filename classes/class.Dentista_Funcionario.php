<?php
  require_once "global.php";

  class Dentista extends Funcionario
  {
    protected static $local_filename = "Dentista.txt";
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista);
      $this->save();
      
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }


?>
