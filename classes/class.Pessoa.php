<?php
  require_once "global.php";

  abstract class Pessoa extends persist
  {
    protected static $local_filename = "Pessoa.txt";
    protected $nome;
    protected $email;
    protected $telefone;

    function __construct($nome, $email, $telefone)
    {
      $this->nome = $nome;
      $this->email = $email;
      $this->telefone = $telefone;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
  }

?>