<?php
  require_once "global.php";

  abstract class Pessoa extends persist
  {
    protected static $local_filename = "Pessoa.txt";
    protected string $nome;
    protected string $email;
    protected $telefone;

    function __construct($nome, $email, $telefone)
    {
      $this->nome = $nome;
      $this->email = $email;
      $this->telefone = $telefone;
    }

    public function get_nome()
    {
      return $this->nome;
    }

    public function get_email()
    {
      return $this->email;
    }

    public function get_telefone()
    {
      return $this->telefone;
    }

  }

?>