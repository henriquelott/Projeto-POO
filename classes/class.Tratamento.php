<?php
require_once "global.php";

class Tratamento extends Orcamento
  {
    protected static $local_filename = "Tratamento.txt";
    private $registro_pagamento;
    private bool $foi_realizado = false;

    function __construct($paciente, $dentista_responsavel, array $procedimentos, $valor_total)
    {
      parent::__construct($paciente, $dentista_responsavel, $procedimentos, $valor_total);
      $this->save();
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
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

    public function get_paciente()
    {
      return $this->paciente;
    }

  }
?>