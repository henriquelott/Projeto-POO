<?php
require_once "global.php";

class Tratamento extends Orcamento
{
  protected static $local_filename = "Tratamento.txt";
  protected ?Registro_Pagamento $registro_pagamento = NULL;
  protected bool $foi_realizado = false;

  function __construct($paciente, $dentista_responsavel, array $procedimentos, Forma_De_Pagamento $forma_pagamento, float $valor_total)
  {
    parent::__construct($paciente, $dentista_responsavel, $procedimentos, $valor_total);
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function cadastar_consulta(Data $data, Procedimento &$procedimento)
  {
    if(in_array($procedimento, $this->procedimentos))
    {
      $dentista = $this->get_dentista_responsavel();
      $dentista->cadastrar_consulta($data);

      $consulta = new Consulta($data, $dentista);

      $paciente = $this->get_paciente();
      $paciente->cadastrar_consulta($consulta);

      $this->save();
    }
    else
    {
      throw (new Exception("\nProcedimento " . $procedimento->get_tipo_procedimento() . " não cadastrado neste tratamento"));
    }
  }
  
  public function realizar_pagamento(Cliente &$cliente_requerido, ?array $formas_pagamento = NULL)
  {
    global $forma_pagamento;
    foreach($this->paciente->get_clientes() as $cliente)
    {
      if($cliente == $cliente_requerido && $formas_pagamento != NULL)
      {
        $soma_porcentagens = 0;
        foreach($formas_pagamento as $key => $value)
        {
          $soma_porcentagens += $value[1];

          switch($value[0])
          {
            case "Cartão de crédito":
              $array = array(new Cartao($value[0], $key), $value[1]);
              $forma_pagamento[] = $array;
              break;

            case "Cartão de débito":
              $array = array(new Cartao($value[0]), $value[1]);
              $forma_pagamento[] = $array;
              break;

            case "Pix":
              $array = array(new A_Vista($value[0]), $value[1]);
              $forma_pagamento[] = $array;
              break;

            case "Dinheiro":
              $array = array(new A_Vista($value[0]), $value[1]);
              $forma_pagamento[] = $array;
              break;

            default:
              throw (new Exception("\nForma de pagamento inválida"));
          }
        }
        if($soma_porcentagens != 1)
        {
          throw (new Exception("\nAs formas de pagamento juntas devem corresponder a 100% do valor total\n"));
        }
      }
      else if($cliente == $cliente_requerido && $formas_pagamento == NULL)
      {
        $forma_pagamento = array ($this->get_forma_pagamento());
      }
      else
      {
        throw(new Exception("\nEsse cliente nao está cadastrado para este paciente\n"));
      }

      $this->registro_pagamento = new Registro_Pagamento($forma_pagamento, $this->valor_total, $cliente_requerido);
      return;
    }
  }

  public function realizar_consulta(Procedimento &$procedimento, DateTime $data)
  {
    foreach($this->procedimentos as $procedimento_atual)
    {
      if($procedimento->get_detalhe() == $procedimento_atual->get_detalhe() && $procedimento->get_tipo_procedimento() == $procedimento_atual->get_tipo_procedimento())
      {
        $procedimento->realizar_consulta($data);
        return;
      }
    }
    throw(new Exception("\nEste procedimento não consta neste tratamento\n"));
  }

public function get_registro_pagamento()
{
  return $this->registro_pagamento;    
}
  
}
?>