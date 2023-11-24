<?php
require_once "global.php";

class Tratamento extends Orcamento
  {
    protected static $local_filename = "Tratamento.txt";
    private $registro_pagamento;

    function __construct($paciente, $dentista_responsavel, array $procedimentos, $data_realizacao)
    {
      parent::__construct($paciente, $dentista_responsavel, $procedimentos, $data_realizacao);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
    
    public function realizar_pagamento(Cliente $cliente_requerido)
    {
      $forma_pagamento;

      foreach($this->getPaciente()->getClientes() as $cliente)
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

  }
?>