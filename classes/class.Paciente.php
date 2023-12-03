<?php
  require_once "global.php";
  
  class Paciente extends Pessoa
  {
    protected static $local_filename = "Paciente.txt";
    protected $rg;
    protected Datetime $nascimento;
    protected array $clientes;
    protected array $consultas;

    function __construct($nome, $email, $telefone, $rg, string $nascimento)
    {
      parent::__construct($nome, $email, $telefone);
      $nascimento = new DateTime($nascimento);
      $this->nascimento = $nascimento;
      $this->rg = $rg;
      $this->nascimento = $nascimento;
      $this->consultas = array();
    }

    static public function getFilename()
    {
      return self::$local_filename;
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

    public function cadastrar_consulta(Consulta &$consulta)
    {
      array_push($this->consultas, $consulta);
      $this->save();
    }

    public function realizar_consulta(DateTime $data)
    {
      foreach ($this->consultas as $key=>$consulta)
      {
        if($consulta->get_data()->get_data_inicio() == $data)
        {
          $consulta->consulta_realizada();
          if(get_class($consulta) != "Consulta_Avalicao")
          {
            unset($this->consultas[$key]);
          }
          $this->save();
          return;
        }
      }
      throw(new Exception("Nenhuma consulta marcada para este paciente nesta data e horário"));
    }

    public function realizar_consulta_avaliacao()
    {
      foreach ($this->consultas as $key=>$consulta)
      {
        if(get_class($consulta) == "Consulta_Avaliacao")
        {
          unset($this->consultas[$key]);
          $this->save();
          return;
        } 
      }
    }

    public function set_nome($nome)
    {
      $this->nome = $nome;

      $this->save();
    }
  }

?>