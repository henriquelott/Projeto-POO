<?php

  abstract class Pessoa 
  {
    protected $nome;
    protected $email;
    protected $telefone;

    function __construct($nome, $email, $telefone)
    {
      $this->nome = $nome;
      $this->email = $email;
      $this->telefone = $telefone;
    }
  }

?>