<?php 
require_once "global.php";


class Facade
{

  public static function realizar_login($user, $pass)
  {
    try
    {   
      $cadastro = Users::getRecordsByField("login", $user);
      $nome_perfil = $cadastro[0]->perfil->nome_perfil;

      if($cadastro[0]->senha == $pass)
      {
        $Usuario = Usuario::construct($cadastro[0]->login, $cadastro[0]->senha, $cadastro[0]->email, $cadastro[0]->perfil->nome_perfil);
        
        if($Usuario == null)
          throw (new Exception("\nUsuário já logado\n"));
        
        else
          $Usuario->save();
      }

      else
        throw (new Exception("\nUsuário e/ou senha inválido(s), Tente novamente!\n"));
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  private static function possui_funcionalidade($usuario, string $funcionalidade)
  {
    if(Usuario::get_instance() == NULL)
    {
      throw (new Exception("\nNenhum usuário logado\n"));
    }
    else if($usuario->get_perfil()->possui_funcionalidade($funcionalidade) == true)
    {
      return;
    }
    else
    {
      throw (new Exception("\nEste perfil não possui essa funcionalidade\n"));
    }
  }


  public static function criar_perfil($tipo_perfil, $funcionalidades, $usuario)
  {
    try
    {
      self::possui_funcionalidade($usuario, __FUNCTION__);
      $Perfil = new Perfil($tipo_perfil, $funcionalidades);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    $Perfil->save();
    return true;
  }


  public static function criar_usuario($usuario, $senha, $email, $nome_perfil)
  {
    try
    {  
      self::possui_funcionalidade($usuario, __FUNCTION__);

      $Perfil = Perfil::getRecordsByField("nome_perfil", $nome_perfil);
      
      if(!empty($Perfil))
      {
        $user = Users::getRecordsByField("usuario", $usuario);
        if($user != null)
        {
          echo "<script>alert('Nome de usuário já existe!');</script>";
          throw (new Exception("\nNome de usuário já existe\n"));
        }

        else
        {
          new Users($usuario, $senha, $email, $Perfil);
          echo "<script>alert('Cadastro criado com sucesso!');</script>";
        }
      }
      else
      {
        throw (new Exception("\nPerfil não encontrado\n"));
      }
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }

  //$descricao, $tipo_procedimento, $preco, &$lista
  public static function cadastrar_orcamento(Usuario $Usuario, Paciente $Paciente, Trabalhador $dentista_responsavel, array $tipo_procedimentos)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      foreach($Paciente->get_consultas() as $consultas_nao_realizadas)
      {
        if(get_class($consultas_nao_realizadas) == "Consulta_Avaliacao")
        {
          throw(new Exception("\nA consulta de avaliacao do paciente ainda nao foi realizada\n"));
        }
      }

      $lista = array();
      
      foreach($tipo_procedimentos as $tipo_procedimento)
      {
        array_push($lista, self::encontrar_procedimento($tipo_procedimento));
      }

      $novo_orcamento = new Orcamento($Paciente, $dentista_responsavel, $lista);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }


  public static function encontrar_procedimento(string $tipo_procedimento)
  {
    $lista_procedimentos = Lista_Procedimentos::getRecords();
    $procedimento = $lista_procedimentos[0]->get_procedimento_pelo_tipo($tipo_procedimento);
    
    if(!empty($procedimento))
    {
      return $procedimento[0];
    }
    else 
    {
      throw (new Exception("\nProcedimento $tipo_procedimento não encontrado\n"));
    }
  }
  

  public static function aprovar_orcamento(Usuario $Usuario, Orcamento $Orcamento)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Orcamento, false);

      $Orcamento->aprovar_orcamento();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }
  

  public static function cadastrar_consulta_de_avaliacao(Usuario $Usuario, Dentista $Dentista, Paciente $Paciente, string $data)
  {    
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);
      
      self::encontrar_instancia($Paciente);
      self::enconrtar_instancia($Dentista);
      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      if(!empty($Paciente))
      {
        if(!empty($Dentista))
        {
          $Dentista->editar_agenda("cadastrar consulta", $data_consulta);
          $Consulta_Avaliacao = new Consulta_Avaliacao($data_consulta, $Dentista);
          $Paciente->cadastrar_consulta($Consulta_Avaliacao);
          
          return true;
        }
        else
        {
          throw(new Exception("\nDentista não cadastrado\n"));
        }
      }
      else 
      {
        throw(new Exception("\nPaciente não cadastrado\n"));
      }

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  public static function cadastrar_consulta(Usuario $Usuario, Dentista $Dentista, Paciente $Paciente, string $data)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Paciente);
      self::enconrtar_instancia($Dentista);
      
      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      if(!empty($Paciente))
      {
        if(!empty($Dentista))
        {
          $Dentista->editar_agenda("cadastrar consulta", $data_consulta);
          $Consulta = new Consulta($data_consulta, $Dentista);
          $Paciente->cadastrar_consulta($Consulta);

          return true;
        }
        else
        {
          throw(new Exception("\nDentista não cadastrado\n"));
        }
      }
      else 
      {
        throw(new Exception("\nPaciente não cadastrado\n"));
      }
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function editar_agenda(Usuario $Usuario)
  {
      try
      {
        self::possui_funcionalidade($Usuario, __FUNCTION__);
      }
      catch(Throwable $t)
      {
        echo $t->getMessage();
        return false;
      }
  }


  public static function editar_informacoes(Usuario $Usuario, $atributo, $valor)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      if($Usuario != Usuario::get_instance())
        throw (new Exception ("Usuário não logado"));

      $Usuario->editar_informacoes($atributo, $valor);
    }
      
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  public static function cadastrar_auxiliar(Usuario $Usuario, Auxiliar $Auxiliar)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Auxiliar, true);

      $Auxiliar->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_secretaria(Usuario $Usuario, Secretaria $Secretaria)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Secretaria, true);

      $Secretaria->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_funcionario(Usuario $Usuario, Dentista_Funcionario $Dentista_Funcionario)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Dentista_Funcionario, true);

      $Dentista_Funcionario->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_parceiro(Usuario $Usuario, Dentista_Parceiro $Dentista_Parceiro)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Dentista_Parceiro, true);

      $Dentista_Parceiro->save();
    }
    
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
 }
  

  public static function cadastrar_cliente(Usuario $Usuario, Cliente $Cliente)
  {  
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Cliente, true);

      $Cliente->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_paciente(Usuario $Usuario, $Paciente)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Paciente, true);

      $Paciente->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_procedimento(Usuario $Usuario, Procedimento $Procedimento)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Procedimento, true);

      $Procedimento->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function criar_procedimento(Usuario $Usuario)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }
  

  public static function cadastrar_especialidade(Usuario $Usuario, Especialidade $Especialidade)
  {
    try
    {
      self::possui_funcionalidade($Usuario, __FUNCTION__);

      self::encontrar_instancia($Especialidade, true);

      $Especialidade->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function realizar_pagamento(Usuario $usuario)
  {
    try
    {
      self::possui_funcionalidade($usuario, __FUNCTION__);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  public static function realizar_consulta(Paciente $paciente, string $data, Usuario $usuario)  :  bool
  {
    try
    {
      self::possui_funcionalidade($usuario, __FUNCTION__);
      $date_time = new DateTime($data);
      $paciente->realizar_consulta($date_time);
    }
    catch(Throwable $t)
    {
       echo $t->getMessage();
      return false;
    }

    return true;
  }

  private static function &encontrar_instancia($instancia, bool $eh_cadastro = false)
  {
    $objeto = get_class($instancia);

    $array = $objeto::getRecords();

    foreach ($array as $record)
    {
      if (($record == $instancia) && (!$eh_cadastro))
      {
        return $record;
      }
      else if (($record == $instancia) && ($eh_cadastro))
      {
        throw (new Exception("\n$objeto já cadastrado\n"));
      }
    }

    if(!$eh_cadastro)
    {
      throw (new Exception("\n$objeto não encontrado\n"));
    }
  }
}


?>