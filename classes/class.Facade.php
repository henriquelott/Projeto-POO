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
          throw (new Exeption("\nUsuário já logado\n"));
        
        else
          $Usuario->save();
      }

      else
        throw (new Exeption("\nUsuário e/ou senha inválido(s), Tente novamente!\n"));
    }
    catch(Trhowable $t)
    {
      $t->getMessage();
      return false;
    }
  }


  private static function possui_funcionalidade($usuario, $funcionalidade)
  {
    if($usuario->get_perfil()->possui_funcionalidade($funcionalidade) == true)
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
      $this->possui_funcionalidade($usuario, __FUNCTION__);
      $Perfil = new Perfil($tipo_perfil, $funcionalidades);
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
    $Perfil->save();
    return true;
  }


  public static function criar_usuario($login, $senha, $email, $nome_perfil, $usuario)
  {
    try
    {  
      $this->possui_funcionalidade($usuario, "Criar usuario");
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
      $t->getMessage();
      return false;
    } 
    $this->save();
    return true;
  }


  //$descricao, $tipo_procedimento, $preco, &$lista
  public static function cadastrar_orcamento(Usuario $Usuario, Paciente $Paciente, Trabalhador $dentista_responsavel, array $tipo_procedimentos)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar orcamento");

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
        array_push($lista, $this->encontrar_procedimento($tipo_procedimento));
      }

      $novo_orcamento = new Orcamento($Paciente, $dentista_responsavel, $lista);
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
    $this->save();
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
      $this->possui_funcionalidade($Usuario, "Aprovar orcamento");
      $orcamentos_existentes = Orcamento::getRecords();

      foreach($orcamentos_existentes as $orcamento_atual)
      {
        if($orcamento_atual == $Orcamento)
        {
          $orcamento_atual->aprovar_orcamento();
        }

      }
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }
  

  public static function cadastrar_consulta_de_avaliacao(Usuario $Usuario, Dentista $Dentista, Paciente $Paciente, string $data)
  {    
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar consulta de avalicao");

      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      if(!empty($Paciente))
      {
        if(!empty($Dentista))
        {
          $Dentista->editar_agenda("cadastrar consulta", $data_consulta);
          $consulta_avaliacao = new Consulta_Avaliacao($data_consulta, $dentista);
          $Paciente->cadastrar_consulta($consulta_avaliacao);
          
          return true;
        }
        else
        {
          throw(new Exception("Dentista não cadastrado"));
        }
      }
      else 
      {
        throw(new Exception("Paciente não cadastrado"));
      }

    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
  }


  public static function cadastrar_consulta(Usuario $Usuario, Consulta $Consulta)
  {
    try
    {
      /*$this->possui_funcionalidade($Usuario, "Cadastrar consulta");

      $consultas = Consulta::getRecords();

      foreach($consultas as $consulta)
      {
        if($consulta == $Consulta)
        {
          throw(new Exception("Esta consulta já está cadastrada"));
        }
      }

      $Consulta->save();*/
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function editar_agenda(Usuario $Usuario)
  {
      try
      {
        $this->possui_funcionalidade($Usuario, "Editar Agenda");
      }
      catch(Throwable $t)
      {
        $t->getMessage();
        return false;
      }
  }


  public static function editar_informacoes(Usuario $Usuario)
  {
      try
      {
        $this->possui_funcionalidade($Usuario, "Editar informações");
      }
      catch(Throwable $t)
      {
        $t->getMessage();
        return false;
      }
  }


  public static function cadastrar_auxiliar(Usuario $Usuario, Auxiliar $Auxiliar)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar auxiliar");

      $auxiliares = Auxiliar::getRecords();

      foreach($auxiliares as $auxiliar)
      {
        if($auxiliar == $Auxiliar)
        {
          throw(new Exception("Este auxiliar já está cadastrado"));
        }
      }

      $Auxiliar->save();
        
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_secretaria(Usuario $Usuario, Secretaria $Secretaria)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar secretaria");

      $secretarias = Secretaria::getRecords();

      foreach($secretarias as $secretaria)
      {
        if($secretaria == $Secretaria)
        {
          throw(new Exception("Esta secretaria já está cadastrada"));
        }
      }

      $Secretaria->save();
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_funcionario(Usuario $Usuario, Dentista_Funcionario $Dentista_Funcionario)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar dentista funcionario");

      $dentistas = Dentista_Funcionario::getRecords();

      foreach($dentistas as $dentista)
      {
        if($dentista == $Dentista_Funcionario)
        {
          throw(new Exception("Este dentista já está cadastrado"));
        }
      }

      $Dentista_Funcionario->save();
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_dentista_parceiro(Usuario $Usuario, Dentista_Parceiro $Dentista_Parceiro)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar dentista parceiro");

      $dentistas = Dentista_Parceiro::getRecords();

      foreach($dentistas as $dentista)
      {
        if($dentista == $Dentista_Parceiro)
        {
          throw(new Exception("Este dentista já está cadastrado"));
        }
      }

      $Dentista_Parceiro->save();
    }
    
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
 }
  

  public static function cadastrar_cliente(Usuario $Usuario, Cliente $Cliente)
  {  
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar cliente");

      $clientes = Cliente::getRecords();

      foreach($clientes as $cliente)
      {
        if($cliente == $Cliente)
        {
          throw(new Exception("Este cliente já está cadastrado"));
        }
      }

      $Cliente->save();
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_paciente(Usuario $Usuario, $Paciente)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar paciente");

      $pacientes = Paciente::getRecords();

      foreach($pacientes as $paciente)
      {
        if($paciente == $Paciente)
        {
          throw(new Exception("Este paciente já está cadastrado"));
        }
      }

      $Paciente->save();
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function cadastrar_procedimento(Usuario $Usuario, Procedimento $Procedimento)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar procedimento");

      $procedimentos = Procedimento::getRecords();

      foreach($procedimentos as $procedimento)
      {
        if($procedimento == $Procedimento)
        {
          throw(new Exception("Este procedimento já está cadastrado"));
        }
      }

      $Procedimento->save();
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function criar_procedimento(Usuario $Usuario)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Criar procedimento");
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
  }
  

  public static function cadastrar_especialidade(Usuario $Usuario, Especialidade $Especialidade)
  {
    try
    {
      $this->possui_funcionalidade($Usuario, "Cadastrar especialidade");

      $especialidades = Especialidade::getRecords();

      foreach($especialidades as $especialidade)
      {
        if($especialidade == $Especialidade)
        {
          throw(new Exception("Esta especialidade já está cadastrada"));
        }
      }

      $Especialidade->save();
    }

    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }


  public static function realizar_pagamento(Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Realizar pagamento");
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
  }


  public static function realizar_consulta(Paciente $paciente, string $data, Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Realizar consulta");
      $date_time = new DateTime($data);
      $paciente->realizar_consulta($date_time);
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
  }
}


?>