<?php 
require_once "global.php";

class Facade
{
  public static function realizar_login($login, $senha)
  {
    try
    {   
      $cadastro = Users::getRecordsByField("login", $login);

      if($cadastro[0]->get_senha() == $senha)
      {
        $Usuario = Usuario::construct($cadastro[0]->get_login(), $cadastro[0]->get_senha(), $cadastro[0]->get_email(), $cadastro[0]->get_perfil());
        
        if($Usuario == null)
          throw (new Exception("\nUsuário já logado\n"));
        
        else
          $Usuario->save();
      }
      else
      {
        throw (new Exception("\nUsuário e/ou senha inválido(s), Tente novamente!\n"));
      }
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }


  private static function possui_funcionalidade(string $funcionalidade)
  {
    $usuario = Usuario::get_instance();

    if($usuario == NULL)
    {
      throw (new Exception("\nNenhum usuário logado\n"));
    }
    else 
    {
      $usuario->get_perfil()->possui_funcionalidade($funcionalidade);
    }
  }


  public static function criar_perfil(string $tipo_perfil, array $funcionalidades)
  {
    try
    {
      //self::possui_funcionalidade(__FUNCTION__);
      $perfil = new Perfil();
      $perfil->criar_perfil($tipo_perfil, $funcionalidades);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }


  public static function criar_usuario(string $login, string $senha, string $email, string $nome_perfil)
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
          new Users($login, $senha, $email, $perfil[0]);
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
  public static function cadastrar_orcamento(Paciente $paciente_parametro, Dentista $dentista_responsavel_parametro, array $tipo_procedimentos)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $paciente = self::encontrar_instancia($paciente_parametro);
      $dentista_responsavel = self::encontrar_instancia($dentista_responsavel_parametro);

      foreach($paciente->get_consultas() as $consultas_nao_realizadas)
      {
        if(get_class($consultas_nao_realizadas) == "Consulta_Avaliacao")
        {
          throw(new Exception("\nA consulta de avaliacao do paciente ainda não foi realizada\n"));
        }
      }
      
      foreach($tipo_procedimentos as $tipo_procedimento)
      {
        array_push($lista, self::encontrar_procedimento($tipo_procedimento));
      }

      $novo_orcamento = new Orcamento($paciente, $dentista_responsavel, $lista);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }


  private static function encontrar_procedimento(string $tipo_procedimento)
  {
    $lista_procedimentos = Lista_Procedimentos::getRecords();
    $procedimento = $lista_procedimentos[0]->get_procedimento_pelo_tipo($tipo_procedimento);
    return $procedimento;
  }
  

  public static function aprovar_orcamento(Orcamento $orcamento_parametro, string $forma_pagamento, int $num_parcelas = 0)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $orcamento = self::encontrar_instancia($orcamento_parametro);

      $orcamento->aprovar_orcamento($forma_pagamento, $num_parcelas);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    echo "funcionas";
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


  public static function cadastrar_consulta(Tratamento $tratamento_parametro, Procedimento $procedimento_parametro, string $data, int $duracao_minutos)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $tratamento = self::encontrar_instancia($tratamento_parametro);  
      $procedimento = self::encontrar_instancia($procedimento_parametro);    
      
      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString("$duracao_minutos minutes");
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      $tratamento->cadastar_consulta()
      
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }

  public function cadastrar_taxa_cartao(string $tipo_cartao, float $taxa_cartao, ?array $num_parcelas = NULL)
  {
    self::possui_funcionalidade(__FUNCTION__);
    $lista_taxas = Lista_Taxas_Cartao::getRecords();
    $lista_taxas[0]->cadastrar_taxa($tipo_cartao, $taxa_cartao, $num_parcelas);
    
  }

  public static function editar_agenda(Dentista $dentista_parametro, string $data, string $comando)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $dentista = self::encontrar_instancia($dentista_parametro);
      $dentista->editar_agenda($comando, $data);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }

  public static function cadastrar_agenda_padrao(Dentista $dentista)
  {

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
    return true;
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


  public static function criar_procedimento(Procedimento $procedimento)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      self::encontrar_instancia($procedimento, true);

      $lista_procedimentos = Lista_Procedimentos::getRecords()[0];

      $lista_procedimentos->cadastrar_procedimento($procedimento);
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_procedimento(Procedimento $procedimento_parametro, Orcamento $orcamento_parametro)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $procedimento = self::encontrar_instancia($procedimento_parametro);
      $orcamento = self::encontrar_instancia($orcamento_parametro);
      $lista_procedimentos = Lista_Procedimentos::getRecords()[0];

      $orcamento->cadastrar_procedimento($procedimento, $lista_procedimentos);

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }

  public static function criar_especialidade(Especialidade $especialidade)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      self::encontrar_instancia($especialidade, true);

      $lista_especialidades = Lista_Especialidades::getRecords()[0];

      $lista_especialidades->cadastrar_especialidade($especialidade);
    }

    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }

  public static function cadastrar_especialidade(Especialidade $especialidade_parametro, Dentista $dentista_parametro)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $especialidade = self::encontrar_instancia($especialidade_parametro);
      $dentista = self::encontrar_instancia($dentista_parametro);
      $lista_especialidades = Lista_Especialidades::getRecords()[0];

      $dentista->cadastrar_especialidade($especialidade, $lista_especialidades);

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
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


  public static function realizar_consulta(Tratamento $tratamento_parametro, string $data)  :  bool
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $tratamento = self::encontrar_instancia($tratamento_parametro);
      $paciente = $tratamento->get_paciente();
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

  private static function &encontrar_instancia($instancia, bool $eh_cadastro = false)  :  ?object
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

    return $instancia;
  }
}

?>