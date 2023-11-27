<?php
  require_once "global.php";
  
  class Orcamento extends persist
  {
    protected static $local_filename = "Orcamento.txt";
    protected Paciente $paciente;
    protected $dentista_responsavel;
    protected Procedimento $procedimentos = array();
    protected $valor_total;

    function __construct($paciente, $dentista_responsavel, Procedimento $procedimentos)
    {
      $this->paciente = $paciente;
      $this->dentista_responsavel = $dentista_responsavel;
      $this->procedimentos = $procedimentos;
      $this->calcular_orcamento();
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function calcular_orcamento()
    {
      foreach($this->procedimentos as $procedimento)
      {
        $this->valor_total += $procedimento->get_valor();
      }
    }
    
    public function aprovar_orcamento()
    {
      return new Tratamento($this->paciente, $this->dentista_responsavel,$this->procedimentos, $this->data_realizacao, $forma_pagamento);
    }

    public function verificar_procedimento(Procedimento $procedimento)
    {
      foreach($this->procedimentos as $procedimento_atual)
      {
        if($procedimento_atual == $procedimento)
        {
          $procedimento_atual->orcamento_possui_procedimento($this);
          break;
        }
      }
     }


    public function cadastar_consulta($data, $tipo_procedimento, $lista)
    {
      $procedimento = $lista->get_procedimento_pelo_tipo($tipo_procedimento);
      foreach($this->procedimentos as $verificar)
      {
        if($verificar == $procedimento)
        {
          $consulta_cadastrada = $verificar->cadastrar_consulta($data,$this->dentista_responsavel);

          array_push($this->paciente->get_consultas(), $consulta_cadastrada);

          $this->save();

          return;
        }
       }

      array_push($this->procedimentos, $procedimento);
      return cadastrar_consulta($data, $tipo_procedimento,$lista);

    }


    public function cadastrar_procedimento($lista, $tipo_procedimento)
    {
      $novo_procedimento = $lista->get_procedimento_pelo_tipo($tipo_procedimento);
      
      foreach($this->procedimentos as $procedimento)
      {
        if($procedimento == $novo_procedimento)
        {
          throw (new Exception ('O procedimento ja esta cadastrado'));
        }
      }

      array_push($this->procedimentos, $novo_procedimento);
      $this->valor_total += $novo_procedimento->get_valor();
      $this->save();
    }

    public function realizar_consulta()
    {
      
    }
    
    public function get_procedimentos()
    {
      return $this->procedimentos;
    }

    public function get_paciente()
    {
      return $this->paciente;
    }
  }
?>