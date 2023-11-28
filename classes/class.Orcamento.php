<?php
  require_once "global.php";
  
  class Orcamento extends persist
  {
    protected static $local_filename = "Orcamento.txt";
    protected Paciente $paciente;
    protected  Dentista $dentista_responsavel;
    protected $procedimentos = array();
    protected float $valor_total;

    function __construct(Paciente $paciente, Dentista $dentista_responsavel, array $procedimentos)
    {
      $this->paciente = $paciente;
      $this->dentista_responsavel = $dentista_responsavel;
      $this->procedimentos = $procedimentos;
      $this->calcular_orcamento();
      $this->save();
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
    
    public function aprovar_orcamento(string $forma_pagamento, ?int $num_parcelas)
    {
      if($forma_pagamento == "Dinheiro" || $forma_pagamento == "Pix")
      {
        $pagamento = new A_Vista($forma_pagamento);
      }
      else if ($forma_pagamento == "Cartão de crédito" || $forma_pagamento == "Cartão de débito")
      {
        switch($forma_pagamento)
        {
          case "Cartão de crédito":
            $pagamento = new Cartao($forma_pagamento);
            break;
          
          case "Cartão de débito":
            

          
        }
      }
      else 
      {
        
      }

      return new Tratamento($this->paciente, $this->dentista_responsavel, $this->procedimentos, $pagamento);
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

    public function realizar_consulta(Datetime $data, Consulta $consulta)
    {
      
    }

    public function get_paciente()
    {
      return $this->paciente;
    }

    public function get_dentista_responsavel()
    {
      return $this->dentista_responsavel;
    }
    
    public function get_procedimentos()
    {
      return $this->procedimentos;
    }

    public function get_valor_total()
    {
      return $this->valor_total;
    }
  }
?>