<?php
require_once "global.php";

class Perfil extends persist 
{
  private $tipo_perfil;
  private $lista_funcionalidades = array
  (
    "Criar perfil" => false,
    "Criar usuario" => false,
    "Cadastrar orcamento" => false,
    "Aprovar tratamento" => false,
    "Cadastrar consulta de avaliacao" => false,
    "Cadastrar consulta" => false,
    "Editar agenda" => false,
    "Editar informacoes" => false,
    "Cadastrar auxiliar" => false, 
    "Cadastrar secretaria" => false,
    "Cadastrar dentista" => false,
    "Cadastrar dentista parceiro" => false,
    "Cadastrar cliente" => false, 
    "Cadastrar paciente" => false,
    "Cadastrar procedimento" => false,
    "Criar procedimento" => false,
    "Cadastrar especialidade" => false,
    "Realizar pagamento" => false
  );

  function __construct($tipo_perfil, $lista_funcionalidades)
  {
    foreach ($lista_funcionalidades as $funcionalidade)
    {
      $achou = false;
      foreach ($this->lista_funcionalidades as $key=>$value)
      {
        if ($funcionalidade == $key)
        {
          $this->lista_funcionalidades[$key] = true;
          $achou = true;
        }
      }
      if($achou == false)
      {
        throw (new Exception("\nFuncionalidade $funcionalidade não encontrada\n"));
      }
    }
    $this->tipo_perfil = $tipo_perfil;
    $this->save();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function possui_funcionalidade($funcionalidade)
  {
    if(isset($this->lista_funcionalidades[$funcionalidade]))
    {
      if($this->lista_funcionalidades[$funcionalidade] == true)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      throw (new Exception("\nFuncionalidade $funcionalidade não encontrada\n"));
    }
  }

  public function get_tipo_perfil()
  {
    return $this->tipo_perfil;
  }
}

?>