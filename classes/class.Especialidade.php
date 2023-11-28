<?php

require_once "global.php";

class Especialidade extends persist
{
  protected static $local_filename = "Especialidade.txt";
  protected string $nome_especialidade;
  protected $procedimentos_possiveis = array();
  protected float $percentual;

  public function __construct(string $nome_especialidade, Procedimento $procedimentos_possiveis, Lista_Especialidades &$lista, float $percentual)
  {
    foreach ($lista->get_especialidades_cadastradas() as $especialidade_cadastrada)
    {
      if($especialidade_cadastrada->get_nome() == $nome_especialidade)
      {
        throw (new Exception ('Especialidade ja cadastrada'));
      }
    }
    $this->nome_especialidade = $nome_especialidade;
    $this->procedimentos_possiveis = $procedimentos_possiveis;
    $this->percentual = $percentual;
    $lista->cadastrar_especialidade($this);
  }

  public static function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function get_nome()
  {
    return $this->nome_especialidade;
  }

  public function get_percentual()
  {
    return $this->percentual;
  }
  
  public function get_procedimentos_possiveis()
  {
    return $this->procedimentos_possiveis;
  }
}

?>
