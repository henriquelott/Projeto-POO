<?php
  require_once "global.php";
  
  class Paciente extends Pessoa
  {
    protected static $local_filename = "Paciente.txt";
    protected $rg;
    protected Datetime $nascimento;
    protected $clientes = array ();
    protected $consultas = array();

    function __contruct($nome, $email, $telefone, $rg, Datetime $nascimento)
    {
      parent::__construct($nome, $email, $telefone);
      $this->rg = $rg;
      $this->nascimento = $nascimento;
      $this->save();
    }

    public function remover_consultas_realizadas(Consulta $consulta)
    {
      $key = array_search($consulta, $this->consultas);
      if($key !== NULL)
      {
        unset($this->consultas[$key]);
        return;
      }
      throw(new Exception("Consulta não encontrada"));
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

    public function &get_clientes()
    {
      return $this->clientes;
    }

    public function &get_consultas()
    {
      return $this->consultas;
    }

    public function realizar_consulta(DateTime $data)
    {
      foreach ($this->consultas as $key=>$consulta)
      {
        if($consulta->get_data()->get_data_inicio() == $data)
        {
          $consulta->foi_realizada();
          unset($this->consultas[$key]);
          return;
        }
      }
      throw(new Exception("Nenhuma consulta marcada para este paciente nesta data e horário"));
    }
  }

?>