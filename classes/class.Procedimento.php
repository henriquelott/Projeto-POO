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
    return self::$local_filename;
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

  public function realizar_consulta(DateTime $data)
  {
    foreach($this->consultas as $consulta)
    {
      if($consulta->get_data()->get_data_inicio() = $data)
      {
        $consulta->consulta_realizada();
        return;
      }
    }
    throw (new Exception ("Consulta nao consta no procedimento"));
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

  public function get_preco()
  {
    return $this->preco;
  }

  public function get_tipo()
  {
    return $this->tipo_procedimento;
  }

  public function get_detalhe()
  {
    return $this->detalhamento->get_detalhamento();
  }

  public function cadastrar_consulta($data, &$dentista, $duracao)
  {
    $consulta_nova = new Consulta($data, $dentista);
    $this->consultas[] = $consulta_nova;

    $this->save();
    $consulta_nova->save();
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