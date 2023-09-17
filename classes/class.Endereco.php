<?php
  require_once "global.php";

  class Endereco
  {
    private $rua;
    private $numero;
    private $bairro;
    private $complemento;
    private $cep;

    function __construct($rua, $numero, $bairro, $complemento, $cep)
    {
      $this->rua = $rua;
      $this->numero = $numero;
      $this->bairro = $bairro;
      $this->complemento = $complemento;
      $this->cep = $cep;
    }
  }

?>