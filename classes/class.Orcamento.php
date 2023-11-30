<?php
  require_once "global.php";
  
  class Orcamento extends persist
  {
    protected static $local_filename = "Orcamento.txt";
    protected Paciente $paciente;
    protected Dentista $dentista_responsavel;
    protected $procedimentos;
    protected float $valor_total;

    function __construct(Paciente $Paciente, Dentista $Dentista_Responsavel, array $procedimentos)
    {
      $this->paciente = $Paciente;
      $this->dentista_responsavel = $Dentista_Responsavel;
      $this->procedimentos = $procedimentos;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function calcular_orcamento()
    {
      $this->valor_total = 0;

      foreach($this->procedimentos as $procedimento)
      {
        $this->valor_total += $procedimento->get_valor();
      }

      return $this->valor_total;
    }
    
    public function aprovar_orcamento(string $forma_pagamento, int $num_parcelas = 0)  : void
    {
      if(($forma_pagamento == "Dinheiro" || $forma_pagamento == "Pix") && $num_parcelas == 0)
      {
        $pagamento = new A_Vista($forma_pagamento);
        $pagamento->save(); 
      }
      else if ($forma_pagamento == "Cartão de crédito" || $forma_pagamento == "Cartão de débito")
      {
        switch($forma_pagamento)
        {
          case "Cartão de crédito":
            if($num_parcelas >= 1 && $num_parcelas <= 6)
            {
              $pagamento = new Cartao($forma_pagamento, $num_parcelas);
              $pagamento->save();
            }
            else
            {
              throw(new Exception("\nNumero de Parcelas deve estar entre 1 e 6\n"));
            }
            break;
          
          case "Cartão de débito":
            if($num_parcelas == 0)
            {
              $pagamento = new Cartao($forma_pagamento);
              $pagamento->save();
            }
            else 
            {
              throw(new Exception("\nCartão de débito não deve possuir parcelas\n"));
            }
            break;

          default:
            throw(new Exception("\nNão é pra entrar neste campo\n"));
        }
      }
      else 
      {
        throw (new Exception("Forma de pagamento inválida"));
      }

      $tratamento = new Tratamento($this->paciente, $this->dentista_responsavel, $this->procedimentos, $pagamento);
      $this->save();
      $tratamento->save();
    }

    public function verificar_procedimento(Procedimento $procedimento)
    {
      foreach($this->procedimentos as $procedimento_atual)
      {
        if($procedimento_atual == $procedimento)
        {
          $procedimento_atual->adicionar_orcamento($this);
          return;
        }
      }
     }

    public function cadastrar_procedimento(Lista_procedimentos $lista, &$procedimento)
    {
      if (get_class($this) == "Orcamento")
      {
        $this->realizar_cadastro_procedimento($lista, $procedimento);  
      }
      else
      {
        throw(new Exception("\nNão é possível cadastrar um procedimento em um tratamento\n"));
      }
    }

    private function realizar_cadastro_procedimento(Lista_procedimentos $lista, Procedimento &$procedimento)
    {
      $lista->procedimento_existe($procedimento);

      $this->dentista_pode_realizar_procedimento($procedimento);

      array_push($this->procedimentos, $procedimento);
      $procedimento->save();
      $this->save();
    }

    private function dentista_pode_realizar_procedimento(Procedimento $procedimento)
    {
      foreach($this->dentista_responsavel->get_especialidades() as $especialidade)
      {
        foreach($especialidade->get_procedimentos_possiveis() as $procedimento_possivel)
        {
          if($procedimento_possivel == $procedimento->get_tipo_procedimento())
          {
            return;
          }
        }
      }

      throw(new Exception("\nDentista responsável não é capacitado para realizar o procedimento " . $procedimento->get_tipo_procedimento() . "\n"));
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