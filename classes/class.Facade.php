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
  public static function cadastrar_orcamento(Orcamento &$orcamento)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $paciente = $orcamento->get_paciente();
      $dentista = $orcamento->get_dentista_responsavel();

      $procedimentos = $orcamento->get_procedimentos();

      $paciente = self::encontrar_instancia($paciente);
      $dentista = self::encontrar_instancia($dentista);

      //var_dump($paciente->get_consultas());

      foreach($procedimentos as &$procedimento)
      {
        self::encontrar_procedimento($procedimento);
      }

      if(!empty($paciente->get_consultas()))
      {
        foreach($paciente->get_consultas() as $consulta)
        {
          if(get_class($consulta) == "Consulta_Avaliacao" && $consulta->get_foi_realizada() == true)
          {
            $paciente->realizar_consulta_avaliacao();
            $orcamento->save();
          }
          else
          {
            throw(new Exception("\nA consulta de avaliacao do paciente ainda não foi realizada\n"));
          }
        }
      }
      else
      {
        throw (new Exception("\nO paciente deve cadastrar uma consulta de avaliação para o cadastro de um orçamento\n"));
      }
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }
  private static function encontrar_procedimento(Procedimento &$procedimento)
  {
    $lista_procedimentos = Lista_Procedimentos::getRecords();
    $lista_procedimentos[count($lista_procedimentos)-1]->procedimento_existe($procedimento);
  }

  public static function aprovar_orcamento(Orcamento &$orcamento, string $forma_pagamento, int $num_parcelas = 0)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $orcamento = self::encontrar_instancia($orcamento);

      $orcamento->aprovar_orcamento($forma_pagamento, $num_parcelas);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }
  
  public static function cadastrar_consulta_de_avaliacao(Dentista &$dentista, Paciente &$paciente, string $data)
  {    
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $paciente = self::encontrar_instancia($paciente);
      $dentista = self::encontrar_instancia($dentista);
      
      $data_inicio = new DateTime($data);
      $data_fim = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim->add($interval);

      $data_consulta = new Data($data_inicio, $data_fim);
      
      $dentista->cadastrar_consulta($data_consulta);
      $consulta_avaliacao = new Consulta_Avaliacao($data_consulta, $dentista);
      $paciente->cadastrar_consulta($consulta_avaliacao);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }


  public static function cadastrar_consulta(Tratamento &$tratamento, Procedimento &$procedimento, string $data, int $duracao_minutos)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $tratamento = self::encontrar_instancia($tratamento);  
      $procedimento = self::encontrar_instancia($procedimento);    

      $data_inicio = new DateTime($data);
      $data_fim = new DateTime($data);
      $interval = DateInterval::createFromDateString("$duracao_minutos minutes");
      $data_fim->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      $tratamento->cadastar_consulta($data_consulta, $procedimento);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }

  public static function cadastrar_taxa_cartao(float $taxa_debito, array $taxas_credito)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $lista_taxas = Lista_Taxas_Cartao::getRecords();
      $lista_taxas[count($lista_taxas)-1]->cadastrar_taxa($taxa_debito, $taxas_credito);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
    return true;
  }

  public static function editar_agenda(Dentista &$dentista, string $data, string $comando)
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

  public static function cadastrar_agenda_padrao(Dentista &$dentista, array $agenda, string $mes_geracao_agenda)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $dentista = self::encontrar_instancia($dentista);
      $dentista->criar_agenda($agenda, $mes_geracao_agenda);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
    }
    return true;
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

  public static function cadastrar_auxiliar(Auxiliar &$auxiliar)
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


  public static function cadastrar_secretaria(Secretaria &$secretaria)
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


  public static function cadastrar_dentista_funcionario(Dentista_Funcionario &$dentista_funcionario)
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


  public static function cadastrar_dentista_parceiro(Dentista_Parceiro &$dentista_parceiro)
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
  

  public static function cadastrar_cliente(Paciente &$paciente, Cliente &$cliente)
  {  
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $paciente = self::encontrar_instancia($paciente);
      self::encontrar_instancia($cliente, true);

      $paciente->cadastrar_cliente($cliente);
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_paciente(Paciente &$paciente)
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


  public static function criar_procedimento(Procedimento &$procedimento)
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


  public static function cadastrar_procedimento(Procedimento &$procedimento, Orcamento &$orcamento)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $procedimento = self::encontrar_instancia($procedimento);
      $orcamento = self::encontrar_instancia($orcamento);
      $lista_procedimentos = Lista_Procedimentos::getRecords()[0];

      $orcamento->cadastrar_procedimento($procedimento, $lista_procedimentos);

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }

  public static function criar_especialidade(Especialidade &$especialidade)
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

  public static function cadastrar_especialidade(Especialidade &$especialidade, Dentista &$dentista)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $especialidade = self::encontrar_instancia($especialidade);
      $dentista = self::encontrar_instancia($dentista);
      $lista_especialidades = Lista_Especialidades::getRecords()[0];

      $dentista->cadastrar_especialidade($especialidade, $lista_especialidades);

    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }


  public static function realizar_pagamento(Tratamento &$tratamento, Cliente &$cliente, ?array $formas_de_pagamento = NULL)
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $tratamento = self::encontrar_instancia($tratamento);
      $cliente = self::encontrar_instancia($cliente);

      $tratamento->realizar_pagamento($cliente, $formas_de_pagamento);
      $tratamento->save();
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }

    return true;
  }


  public static function realizar_consulta(string $data, ?Paciente &$paciente = NULL, ?Tratamento &$tratamento = NULL, ?Procedimento &$procedimento = NULL)  :  bool
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);
      $date_time = new DateTime($data);

      if(func_num_args() == 2 && $paciente != NULL)
      {
        $paciente = self::encontrar_instancia($paciente);
      }
      else if(func_num_args() == 3 && $tratamento != NULL)
      {
        $tratamento = self::encontrar_instancia($tratamento_parametro);
        $paciente = $tratamento->get_paciente();
        $tratamento->realizar_consulta($procedimento, $date_time);
      }
      else
      {
        throw (new Exception("\nParâmetros inválido\n"));
      }

      $paciente->realizar_consulta($date_time);
    }
    catch(Throwable $t)
    {
       echo $t->getMessage();
      return false;
    }

    return true;
  }

  private static function &encontrar_instancia(&$instancia, bool $eh_cadastro = false)  :  ?object
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


  private static function calcular_resultado_mensal_iterado(string $classe)  :  float
  {
    $classes = $classe::getRecords();

    $resultado_mensal = 0;

    foreach($classes as $objeto)
    {
      $array_index = array();
      $var = true;
      foreach($array_index as $index)
      {
        if($objeto->get_index() == $index)
        {
          break;
          $var = false;
        }
      }

      if($var == true)
      {
        $array_index[] = $objeto->get_index();
        $objeto_x = $classe::getRecordsByField("index", $objeto->get_index());
        switch($classe)
        {
          case "Tratamento":
            $resultado_mensal += $objeto_x[count($objeto_x)-1]->get_receita();
            break;

          case "Dentista_Parceiro":
            $resultado_mensal -= $objeto_x[count($objeto_x)-1]->get_comissao();
            break;

          default:
          $resultado_mensal -= $objeto_x[count($objeto_x)-1]->get_salario();
        }
      }
    }

    return $resultado_mensal;
  }

  public static function calcular_resultado_mensal() : bool
  {
    try
    {
      self::possui_funcionalidade(__FUNCTION__);

      $resultado = 0;
      $array = array("Tratamento", "Dentista_Parceiro", "Dentista_Funcionario", "Secretaria", "Auxiliar");

      foreach ($array as $classe)
      {
        $resultado += self::calcular_resultado_mensal_iterado($classe);
      }
      
      echo "\nResultado mensal: $resultado\n";
      return true;
    }
    catch(Throwable $t)
    {
      echo $t->getMessage();
      return false;
    }
  }
}

?>