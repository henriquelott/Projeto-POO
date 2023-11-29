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


  private static function possui_funcionalidade(string $funcionalidade)
  {
    $usuario = Usuario::get_instance();

    if($usuario)
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
      self::possui_funcionalidade(__FUNCTION__);
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


  public static function criar_usuario($login, $senha, $email, $nome_perfil)
  {
    try
    {  
      self::possui_funcionalidade(__FUNCTION__);

      $perfil = Perfil::getRecordsByField("nome_perfil", $nome_perfil);
      
      if(!empty($perfil))
      {
        $user = Users::getRecordsByField("login", $login);
        if($user != null)
        {
          echo "<script>alert('Nome de usuário já existe!');</script>";
          throw (new Exception("\nNome de usuário já existe\n"));
        }
        else
        {
          new Users($login, $senha, $email, $perfil);
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
      self::possui_funcionalidade(__FUNCTION__);

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
    return $procedimento;
  }
  

  public static function aprovar_orcamento(Orcamento $Orcamento, string $forma_pagamento, ?int $num_parcelas)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($Orcamento, false);

      $Orcamento->aprovar_orcamento($forma_pagamento, $num_parcelas);
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
      self::possui_funcionalidade(__FUNCTION__);

      $paciente = self::encontrar_instancia($Paciente);
      $dentista = self::encontrar_instancia($Dentista);
      
      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);
      
      $dentista->editar_agenda("cadastrar consulta", $data_consulta);
      $consulta_avaliacao = new Consulta_Avaliacao($data_consulta, $Dentista);
      $paciente->cadastrar_consulta($consulta_avaliacao);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_consulta(Dentista $Dentista, Paciente $Paciente, string $data, int $duracao_minutos)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $paciente = self::encontrar_instancia($Paciente);
      $dentista = self::encontrar_instancia($Dentista);
      
      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString("$duracao_minutos minutes");
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      $dentista->editar_agenda("cadastrar consulta", $data_consulta);
      $consulta = new Consulta($data_consulta, $Dentista);
      $paciente->cadastrar_consulta($consulta);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function editar_agenda()
  {
      try
      {
        self::possui_funcionalidade(__FUNCTION__);
      }
      catch(Throwable $t)
      {
        echo $t->getMessage();
        return false;
      }
  }

  public static function editar_informacoes()
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }

  public static function editar_informacoes_usuario($atributo, $valor)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $usuario = Usuario::get_instance();
      $usuario->editar_informacoes($atributo, $valor);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }

  public static function cadastrar_auxiliar(Auxiliar $auxiliar)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($auxiliar, true);

      $auxiliar->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_secretaria(Secretaria $secretaria)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($secretaria, true);

      $secretaria->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_funcionario(Dentista_Funcionario $dentista_funcionario)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($dentista_funcionario, true);

      $dentista_funcionario->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_parceiro(Dentista_Parceiro $dentista_parceiro)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($dentista_parceiro, true);

      $dentista_parceiro->save();
    }
    
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
 }
  

  public static function cadastrar_cliente(Cliente $cliente)
  {  
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($cliente, true);

      $cliente->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_paciente($paciente)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($paciente, true);

      $paciente->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_procedimento(Procedimento $procedimento)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($procedimento, true);

      $procedimento->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function criar_procedimento(string $tipo_procedimento, string $especialidade_requerida)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }
  

  public static function cadastrar_especialidade(Especialidade $especialidade)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($especialidade, true);

      $especialidade->save();
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function realizar_pagamento()
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  public static function realizar_consulta(Paciente $paciente_parametro, string $data)  :  bool
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $paciente = self::encontrar_instancia($paciente_parametro);
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