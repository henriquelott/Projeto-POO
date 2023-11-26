<?php 
require_once "global.php";


class Facade extends persist
{
  public function realizar_login($user, $pass)
  {
    /* Se o campo usuário ou senha estiverem vazios geramos um alerta */
    if($user == "" || $pass == ""){
      echo "<script>alert('Por favor, preencha todos os campos!');</script>";
    }
    /* Caso o campo usuario e senha não 
      *estejam vazios vamos testar se o usuário e a senha batem 
    *iniciamos uma sessão e redirecionamos o usuário para o painel */
    else
    {
      $perfil = Users::getRecordsByField("login", $user);
      $tipo_perfil = $perfil[0]->tipo_perfil;

      if($perfil[0]->senha == $pass) 
      {
        if(!isset($_SESSION)) {
            session_start();
        }
        //$_SESSION['Usuario'] = $user;

        $Usuario = Usuario::get_instance($perfil[0]->login, $perfil[0]->senha, $perfil[0]->email, $perfil[0]->tipo_perfil);
        $Usuario->save();

        //header("Location: _painel.php");
        header("Location: _painel.php?usuario=$user&tipo_perfil=$tipo_perfil");
        }
        echo "<script>alert('Usuário e/ou senha inválido(s), Tente novamente!');</script>";
    }
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  private function possui_funcionalidade($usuario, $funcionalidade)
  {
    if($usuario->get_perfil()->possui_funcionalidade($funcionalidade) == true)
    {
      return;
    }
    else
    {
      throw (new Exception("Este perfil não possui essa funcionalidade"));
    }
  }

  public function criar_perfil($tipo_perfil, $funcionalidades, $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Criar perfil");
        new Perfil($tipo_perfil, $funcionalidades);
      }
      catch(Throwable $t)
      {
          return false;
      }
  }

  public function criar_usuario($login, $senha, $email, $tipo_perfil, $usuario)
  {
    try
    {  
      $this->possui_funcionalidade($usuario, "Criar usuario");
      $perfil = self::getRecordsByField($tipo_perfil, $tipo_perfil);
      if(!empty($perfil))
      {
        new Usuario ($login, $senha, $email, $perfil[0]);
      }
      else
      {
        throw (new Exception("Perfil não encontrado"));
      }
    }
    catch(Throwable $t)
    {
      return;
    }  
  }

  //$descricao, $tipo_procedimento, $preco, &$lista
  public function cadastrar_orcamento(Paciente $paciente, Trabalhador $dentista_responsavel, array $tipo_procedimentos, Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar orcamento");
    }
    catch(Throwable $t)
    {
        return;
    }
  }

  public function encontrar_procedimento(string $tipo_procedimento)
  {
    
  }
  
  public function aprovar_tratamento(Usuario $usuario)
  {
    $this->possui_funcionalidade($usuario, "Aprovar tratamento");
      try
      {

      }
      catch(Throwable $t)
      {
          return;
      }
  }
  
  public function cadastrar_consulta_de_avaliacao(Usuario $usuario)
  {   
      $this->possui_funcionalidade($usuario, "Cadastrar consulta de avalicao");
      try
      {

      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function cadastrar_consulta(Usuario $usuario)
  {
      $this->possui_funcionalidade($usuario, "Cadastrar consulta");
      try
      {

      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function editar_agenda(Usuario $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Editar Agenda");
      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function editar_informacoes(Usuario $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Editar informações");
      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function cadastrar_auxiliar(Usuario $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar auxiliar");
      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function cadastrar_secretaria(Usuario $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar secretaria");
      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function cadastrar_dentista(Usuario $usuario)
  {
    if()
    {
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar dentista");
      }
      catch(Throwable $t)
      {
          return;
      }
    }
  }

  public function cadastrar_dentista_parceiro(Usuario $usuario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar dentista parceiro");
      }
      catch(Throwable $t)
      {
          return;
      }
  }

  public function cadastrar_cliente(Usuario $usuario)
  {  
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar cliente");
    }
    catch(Throwable $t)
    {
        return;
    }
  }

  public function cadastrar_paciente(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar paciente");
    }
    catch(Throwable $t)
    {
        return;
    }
  }

  public function cadastrar_procedimento(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar procedimento");
    }
    catch(Throwable $t)
    {
      return;
    }
  }

  public function criar_procedimento(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Criar procedimento");
    }
    catch(Throwable $t)
    {
      return;
    }
  }
  
  public function cadastrar_especialidade(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar especialidade");
    }
    catch(Throwable $t)
    {
      return;
    }
  }

  public function realizar_pagamento(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Realizar pagamento");
    }
    catch(Throwable $t)
    {
      return;
    }
  }
}


?>