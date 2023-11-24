<?php
  require_once "global.php";
  
  class Paciente extends Pessoa
  {
    protected static $local_filename = "Paciente.txt";
    private $rg;
    private $nascimento;
    private $clientes = array ();
    private $consultas = array();

    function __contruct($nome, $email, $telefone, $rg, $nascimento)
    {
      parent::__construct($nome, $email, $telefone);
      $this->rg = $rg;
      $this->nascimento = $nascimento;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function cadastrar_cliente($cliente)
    {
      array_push($this->clientes, $cliente);
    }
    
    public function confirmar_pagamento($recibo, $cliente)
    {
      
    }

    public function get_clientes()
    {
      return $this->clientes;
    }

    public function get_consultas()
    {
      return $this->consultas;
    }
  }

?>