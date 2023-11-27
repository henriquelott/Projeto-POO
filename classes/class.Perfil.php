<?php
require_once "global.php";

class Perfil extends persist 
{
  protected static $local_filename = "Perfil.txt";
  private $nome_perfil;
  private $lista_funcionalidades = array
  (
    "Criar perfil" => false,
    "Criar usuario" => false,
    "Cadastrar orcamento" => false,
    "Aprovar orcamento" => false,
    "Cadastrar consulta de avaliacao" => false,
    "Cadastrar consulta" => false,
    "Editar agenda" => false,
    "Editar informacoes" => false,
    "Cadastrar auxiliar" => false, 
    "Cadastrar secretaria" => false,
    "Cadastrar dentista funcionario" => false,
    "Cadastrar dentista parceiro" => false,
    "Cadastrar cliente" => false, 
    "Cadastrar paciente" => false,
    "Cadastrar procedimento" => false,
    "Criar procedimento" => false,
    "Cadastrar especialidade" => false,
    "Realizar pagamento" => false
  );

  function __construct($nome_perfil, $lista_funcionalidades)
  {
    foreach ($lista_funcionalidades as $funcionalidade)
    {
      foreach ($this->lista_funcionalidades as $key=>$value)
      {
        if ($funcionalidade == $key)
        {
          $this->lista_funcionalidades[$key] = true;
          break;
        }
        throw (new Exception("\nFuncionalidade $funcionalidade não encontrada\n"));
      }
    }
    $this->nome_perfil = $nome_perfil;
    $this->save();
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function possui_funcionalidade($funcionalidade)
  {
    foreach(array_keys($this->lista_funcionalidades) as $key))
    {  
      if($key == $funcionalidade)
        return $this->lista_funcionalidades[$funcionalidade];
    }
    
    throw (new Exception("\nFuncionalidade $funcionalidade não encontrada\n"));
  }

  public function get_nome_perfil()
  {
    return $this->nome_perfil;
  }
}

?>