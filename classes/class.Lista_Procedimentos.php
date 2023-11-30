<?php
require_once "global.php";
class Lista_Procedimentos extends persist
{
  protected static $local_filename = "Lista_Procedimentos.txt";
  protected array $procedimentos;

  function __construct()
  {
    $this->procedimentos = Procedimento::getRecords();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function cadastrar_procedimento(Procedimento &$procedimento)
  {
    array_push($this->procedimentos, $procedimento);
    $procedimento->save();
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

  public function get_procedimentos_cadastrados()  :  array
  {
    return $this->procedimentos;
  }

  public function procedimento_existe(Procedimento $procedimento) : void
  {
    foreach($this->procedimentos as $procedimento_atual)
    {
      if(($procedimento_atual->get_tipo_procedimento() == $procedimento->get_tipo_procedimento()) && ($procedimento_atual->get_descricao() == $procedimento->get_descricao()) && ($procedimento_atual->get_valor() == $procedimento->get_descricao()))
      {
        return;
      }
    }
    throw (new Exception("\nProcedimento " . $procedimento->get_tipo_procedimento() . " não cadastrado\n"));
  }
}


?>