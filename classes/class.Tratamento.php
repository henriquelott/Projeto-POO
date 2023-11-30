<?php
require_once "global.php";

class Tratamento extends Orcamento
  {
    protected static $local_filename = "Tratamento.txt";
    protected Registro_Pagamento $registro_pagamento;
    protected bool $foi_realizado = false;

    function __construct($paciente, $dentista_responsavel, array $procedimentos, Forma_De_Pagamento $forma_pagamento)
    {
      parent::__construct($paciente, $dentista_responsavel, $procedimentos);
      $this->registro_pagamento = new Registro_Pagamento($forma_pagamento);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function cadastar_consulta(Data $data, Procedimento &$procedimento, Consulta &$consulta)
    {
      if(in_array($procedimento, $this->procedimentos))
      {
        $dentista = $this->get_dentista_responsavel();
        $dentista->cadastrar_consulta($data, $procedimento);

        $paciente = $this->get_paciente();
        $paciente->cadastrar_consulta($consulta);

        $this->save();
      }
      else
      {
        throw (new Exception("\nProcedimento " . $procedimento->get_tipo_procedimento() . " não cadastrado"));
      }
    }
    
    public function realizar_pagamento(Cliente $cliente_requerido)
    {
      foreach($this->get_paciente()->get_clientes() as $cliente)
      {
          if($cliente == $cliente_requerido)
          {
            $forma_pagamento = $cliente->pagar($this->valor_total);
            $this->registro_pagamento = new Registro_Pagamento($forma_pagamento);
            return;
          }
      }
      throw(new Exception('Esse cliente nao esta cadastrado'));
    }

    public function realizar_consulta(Datetime $data, Consulta $consulta)
    {
      
    }

  }
?>