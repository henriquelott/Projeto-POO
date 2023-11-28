<?php
require_once "global.php";
class Lista_Procedimentos extends persist
{
  protected static $local_filename = "Lista_Procedimentos.txt";
  protected Procedimento $procedimentos = array();

  function __construct()
  {
    $this->procedimentos = Procedimentos::getRecords();
  }

  static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

  public function cadastrar_procedimento($procedimento)
  {
    array_push($this->procedimentos,$procedimento);
    $this->save();
  }

  public function get_preco_procedimento($procedimento)
  {
    foreach($this->procedimentos as $procedimento_atual)
    {
      if($procedimento_atual->get_tipo_procedimento() == $procedimento->get_tipo_procedimento())
      {
        return $procedimento_atual->preco;
      }
    }
  }

  public function get_procedimentos_cadastrados()
  {
    return $this->procedimentos;
  }

  public function get_procedimento_pelo_tipo($tipo_procedimento) : Procedimento
  {
    foreach($this->procedimentos as $procedimento)
    {
      if($procedimento->get_tipo_procedimentos() == $tipo_procedimento)
      {
        return $procedimento;
      }
    }
    throw (new Exception('Procedimento nao cadastrado'));
  }
}


?>