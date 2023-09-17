<?php
  require_once "global.php";
  
  class Paciente extends Pessoa
  {
    private $rg;
    private $nascimento;
    private $clientes = array ();

    function __contruct($nome, $email, $telefone, $rg, $nascimento)
    {
      parent::__construct($nome, $email, $telefone);
      
      $this->rg = $rg;
      $this->nascimento = $nascimento;
    }

    public function cadastrarCliente($cliente)
    {
      array_push($this->clientes, $cliente);
    }
    
    public function confirmaPagamento($recibo)
    {
      
    }
  }

?>