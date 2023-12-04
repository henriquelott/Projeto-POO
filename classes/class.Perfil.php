<?php
require_once "global.php";

class Perfil extends persist 
{
  protected static string $local_filename = "Perfil.txt";
  protected ?string $nome_perfil = NULL;
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
    "cadastrar_dentista"  => false,
    "cadastrar_cliente" => false, 
    "cadastrar_paciente" => false,
    "cadastrar_procedimento" => false,
    "criar_procedimento" => false,
    "criar_especialidade" => false, 
    "cadastrar_especialidade" => false,
    "realizar_pagamento" => false,
    "cadastrar_taxa_cartao" => false,
    "calcular_resultado_mensal" => false, 
    "cadastrar_agenda_padrao" => false,
    "cadastrar_consulta_de_avaliacao"=> false,
    "realizar_consulta" => false,
  );

  function __construct(string $nome_perfil, array $funcionalidades, ?bool $eh_admin = false)
  {
    $this->nome_perfil = NULL;
    if($eh_admin)
    {
      $perfil = Perfil::getRecordsByField("nome_perfil", "admin");

      if(empty($perfil))
      {
        $this->nome_perfil = "admin";
        foreach($this->lista_funcionalidades as $key => &$value)
        {
          $value = true;
        }
        $this->save();
      }
    }
    else
    {
      $this->criar_perfil($nome_perfil, $funcionalidades);
    }
  }

  private function criar_perfil(string $nome_perfil, array $lista_funcionalidades)
  {
    if(Perfil::getRecordsByField("nome_perfil", $nome_perfil) != null)
    {
      throw (new Exception("Perfil $nome_perfil já cadastrado"));
    }

    foreach ($lista_funcionalidades as $funcionalidade)
    {
      $achou = false;
      foreach ($this->lista_funcionalidades as $key=>$value)
      {
        if ($funcionalidade == $key)
        {
          $this->lista_funcionalidades[$key] = true;
          $achou = true;
          break;
        }
      }
      if (!$achou)
        throw (new Exception("\nFuncionalidade $funcionalidade não cadastrada\n"));
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
    if($this->lista_funcionalidades[$funcionalidade])
    {
      return;
    }
    
    throw (new Exception("\nEste perfil não possui a funcionalidade $funcionalidade\n"));
  }

  public function get_nome_perfil()
  {
    return $this->nome_perfil;
  }

  public function get_lista_funcionalidades()  :  array
  {
    return $this->lista_funcionalidades;
  }
}

?>