<?php

require_once "global.php";

class Especialidade extends persist
{
  protected static $local_filename = "Especialidade.txt";
  protected string $nome_especialidade;
  protected array $procedimentos_possiveis;
  protected float $percentual;

  public function __construct(string $nome_especialidade, array $procedimentos_possiveis, float $percentual,)
  {
    $this->nome_especialidade = $nome_especialidade;
    $this->procedimentos_possiveis = $procedimentos_possiveis;
    $this->percentual = $percentual;
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
