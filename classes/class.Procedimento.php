<?php
require_once "global.php";

class Procedimento extends persist
{
  protected static $local_filename = "Procedimento.txt";
  protected array $consultas;
  protected float $preco;
  protected string $tipo_procedimento;
  protected string $descricao;
  protected Detalhe_Procedimento $detalhamento;
  protected Data $data;

  protected bool $foi_realizado = false;

  function __construct($descricao, $tipo_procedimento, $preco, string $detalhe)
  {
    $this->descricao = $descricao;
    $this->tipo_procedimento = $tipo_procedimento;      
    $this->preco = $preco;
    $this->detalhamento = new Detalhe_Procedimento($detalhe);
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function verificar_destista($dentista, $tipo_procedimento)
  {
    foreach ($dentista->get_especialidades() as $especialidade)
    {
      foreach ($especialidade->get_procedimentos_possiveis() as $procedimento)
      {
        if ($procedimento->get_tipo_procedimento() == $tipo_procedimento)
        {
          return true;
        }
      }
    }
    return false;
  }

  public function realizar_consulta(Consulta $consulta_realizada)
  {
      $key = array_search($consulta_realizada, $this->consultas);
      if($key !== NULL)
      {
        $this->consultas[$key]->consulta_realizada();
      } 
      else
      {
        throw (new Exception ('Consulta nao consta no procedimento'));
      }
  }

  public function get_tipo_procedimento()  :  string
  {
    return $this->tipo_procedimento;
  }

  public function orcamento_possui_procedimento(Orcamento $orcamento)
  {
    $this->detalhamento->adicionar_orcamento($orcamento);
  }

  public function get_descricao()
  {
    return $this->tipo_procedimento;
  }

  public function get_valor()
  {
    return $this->preco;
  }

  public function &cadastrar_consulta($data, &$dentista, $duracao)
  {
    foreach($this->consultas as $consultas_existentes)
    {
      $ano = $consultas_existentes->get_data_consulta()->get_ano();
      $mes = $consultas_existentes->get_data_consulta()->get_mes();
      $dia = $consultas_existentes->get_data_consulta()->get_dia();
      $horario = $consultas_existentes->get_data_consulta()->get_horario();
      $duracao_existente = $consultas_existentes->get_duracao();

      if($ano == $data->get_ano() && $mes == $data->get_mes() && $dia == $data->get_dia() && $data->get_horario() >= $horario && $data->get_horario() <= $horario + $duracao_existente)
      {
        throw (new Exception("Ja existe uma consulta cadastrada nessa data"));
      }
      
    }
    $dentista->get_agenda()->cadastrar_consulta($data);

    $consulta_nova = new Consulta($data, $dentista);
  
    array_push($this->consultas, $consulta_nova);

    return $consulta_nova;
  }

  public function cancelar_consulta_paciente(Consulta $consulta)
  {
      foreach ($this->consultas as $consult)
      {
          if($consult == $consulta)
          {
            $consult->cancelar_consulta_paciente();
            return;
          }
      }
    
      throw (new Exception("Consulta nao consta no procedimento"));
  }

  public function cancelar_consulta_dentista(Consulta $consulta)
  {
      foreach ($this->consultas as $consult)
      {
          if($consult == $consulta)
          {
            $consult->cancelar_consulta_dentista();
            return;
          }
      }

      throw (new Exception("Consulta nao consta no procedimento"));
  }

  public function &get_consulta()
  {
   return $this->consultas;   
  }

}

?>