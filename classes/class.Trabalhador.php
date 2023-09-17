<?php
  require_once "global.php";

  abstract class Trabalhador extends Pessoa
  {  
    protected $cpf;
    protected $endereco;

    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep)
    {
      parent::__construct($nome, $email, $telefone);

      $this->cpf = $cpf;
      $this->endereco = new Endereco($rua, $numero, $bairro, $complemento, $cep);
    }
  }

?>