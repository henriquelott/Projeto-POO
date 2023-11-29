<?php
require_once "global.php";

class Perfil extends persist 
{
  protected static string $local_filename = "Perfil.txt";
  protected string $nome_perfil;
  protected array $lista_funcionalidades = array
  (
    "criar_perfil" => false,
    "criar_usuario" => false,
    "cadastrar_orcamento" => false,
    "aprovar_orcamento" => false,
    "cadastrar_consulta_avaliacao" => false,
    "cadastrar_consulta" => false,
    "editar_agenda" => false,
    "editar_informacoes" => false,
    "cadastrar_auxiliar" => false, 
    "cadastrar_secretaria" => false,
    "cadastrar_dentista_funcionario" => false,
    "cadastrar_dentista_parceiro" => false,
    "cadastrar_cliente" => false, 
    "cadastrar_paciente" => false,
    "cadastrar_procedimento" => false,
    "criar_procedimento" => false,
    "cadastrar_especialidade" => false,
    "realizar_pagamento" => false
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
    foreach(array_keys($this->lista_funcionalidades) as $key)
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