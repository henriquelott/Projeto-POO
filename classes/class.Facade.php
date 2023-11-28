<?php 
require_once "global.php";


class Facade extends persist
{
  protected static $local_filename = "Facade.txt";
  
  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }
  
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
      $cadastro = Users::getRecordsByField("login", $user);
      $nome_perfil = $cadastro[0]->perfil->nome_perfil;

      if($cadastro[0]->senha == $pass) 
      {
        if(!isset($_SESSION)) {
            session_start();
        }

        Usuario::get_instance($cadastro[0]->login, $cadastro[0]->senha, $cadastro[0]->email, $cadastro[0]->perfil->nome_perfil);

        header("Location: _painel.php");
        }
        echo "<script>alert('Usuário e/ou senha inválido(s), Tente novamente!');</script>";
    }
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
      $t->getMessage();
      return false;
    }
    $this->save();
    return true;
  }

  public function criar_usuario($login, $senha, $email, $nome_perfil, $usuario)
  {
    try
    {  
      $this->possui_funcionalidade($usuario, "Criar usuario");
      $perfil = Perfil::getRecordsByField("nome_perfil", $nome_perfil);
      if(!empty($perfil))
      {
        if(null != ($login && $senha && $email))
          {
            $user = Users::getRecordsByField("usuario", $usuario);
            if($user != null)
            {
              echo "<script>alert('Nome de usuário já existe!');</script>";
              throw (new Exception("Nome de usuário já existe"));
            }

            else
            {
              new Users($usuario, $senha, $email, $perfil);
              echo "<script>alert('Cadastro criado com sucesso!');</script>";
            }
          }
        else {
          echo "<script>alert('Preencha todos os campos!');</script>";    
        }
      }
      else
      {
        throw (new Exception("Perfil não encontrado"));
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
  public function cadastrar_orcamento(Paciente $paciente, Trabalhador $dentista_responsavel, array $tipo_procedimentos, Usuario $usuario)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar orcamento");
      foreach($paciente->get_consultas() as $consultas_nao_realizadas)
        {
          if(get_class($consultas_nao_realizadas) == "Consulta_Avaliacao")
          {
            throw(new Exception("A consulta de avaliacao do paciente ainda nao foi realizada"));
          }
        }

      $procedimentos = array();
      $lista = array();

      foreach($tipo_procedimentos as $tipo_procedimento)
        {
          array_push($lista,$this->encontrar_procedimento($tipo_procedimento));
        }
      $novo_orcamento = new Orcamento($paciente, $dentista_responsavel, $lista);
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
    $this->save();
    return true;
  }

  public function encontrar_procedimento(string $tipo_procedimento)
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
  
  public function aprovar_orcamento(Usuario $usuario, Orcamento $orcamento)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Aprovar orcamento");
      $orcamentos_existentes = Orcamento::getRecords();

      foreach($orcamentos_existentes as $orcamento_atual)
      {
        if($orcamento == $orcamento_atual)
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
  }
  
  public function cadastrar_consulta_de_avaliacao(int $dentista_cpf, int $rg_paciente, string $data, Usuario $usuario)
  {    
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar consulta de avalicao");
      
      $dentista_f = Dentista_Funcionario::getRecordsByField("cpf", $dentista_cpf)[0];
      $dentista_p = Dentista_Parceiro::getRecordsByField("cpf", $dentista_cpf)[0];
      $paciente = Paciente::getRecordsByField("rg", $rg_paciente)[0];

      $data_inicio = new DateTime($data);
      $interval = DateInterval::createFromDateString('30 minutes');
      $data_fim = $data_inicio->add($interval);
      $data_consulta = new Data($data_inicio, $data_fim);

      if(!empty($paciente))
      {
        if(!empty($dentista_p))
        {
          $dentista_p->editar_agenda("cadastrar consulta", $data_consulta);
          $consulta_avaliacao = new Consulta_Avaliacao($data_consulta, $dentista_p);
          $paciente->cadastar_consulta($consulta_avaliacao);
          
          return true;
        }
        else if(!empty($dentista_f))
        {
          $dentista_f->editar_agenda("cadastrar consulta", $data_consulta);
          $consulta_avaliacao = new Consulta_Avaliacao($data_consulta, $dentista_p);
          $paciente->cadastar_consulta($consulta_avaliacao);

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

  public function cadastrar_consulta(Usuario $usuario)
  {
      
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar consulta");
      }
      catch(Throwable $t)
      {
        $t->getMessage();
        return false;
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
        $t->getMessage();
        return false;
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
        $t->getMessage();
        return false;
      }
  }

  public function cadastrar_auxiliar(Usuario $usuario, $nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
  {
      try
      {
        $this->possui_funcionalidade($usuario, "Cadastrar auxiliar");

        $cpf_cadastrados = Auxiliar::getRecordsByField("cpf",$cpf);

        if(!empty($cpf_cadastrados))
        {
          throw(new Exception("Esse auxiliar já está cadastrado"));
        }
        $novo_auxiliar = new Auxiliar($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
        
      }
      catch(Throwable $t)
      {
        $t->getMessage();
        return false;
      }
    return true;
  }

  public function cadastrar_secretaria(Usuario $usuario,$nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
  {
    try
    {
        $this->possui_funcionalidade($usuario, "Cadastrar secretaria");

        $cpf_cadastrados = Secretaria::getRecordsByField("cpf",$cpf);

        if(!empty($cpf_cadastrados))
        {
          throw(new Exception("Essa secretária já está cadastrado"));
        }
        $nova_secretaria = new Secretaria($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);

    }
      catch(Throwable $t)
      {
        $t->getMessage();
        return false;
      }
    return true;
  }

  public function cadastrar_dentista_funcionario(Usuario $usuario, $nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar dentista funcionario");

      $cpf_cadastrados = Dentista_Funcionario::getRecordsByField("cpf",$cpf);

      if(!empty($cpf_cadastrados))
      {
        throw(new Exception("Esse dentista funcionario já está cadastrado"));
      }
      $novo_dentista_funcionario = new Dentista_Funcionario($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidades, $lista);

    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }
    return true;
  }

  public function cadastrar_dentista_parceiro(Usuario $usuario, $nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar dentista parceiro");

      $cpf_cadastrados = Dentista_Parceiro::getRecordsByField("cpf",$cpf);

      if(!empty($cpf_cadastrados))
      {
        throw(new Exception("Esse dentista parceiro já está cadastrado"));
      }
      $novo_dentista_parceiro = new Dentista_Parceiro($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidades, $lista);

    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

    return true;
 }
  

  public function cadastrar_cliente(Usuario $usuario, $nome, $email, $telefone, $rg, $cpf)
  {  
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar cliente");

      $cpf_cadastrados = Cliente::getRecordsByField("cpf",$cpf);

      if(!empty($cpf_cadastrados))
      {
        throw(new Exception("Esse cliente já está cadastrado"));
      }
      $novo_cliente = new Cliente($nome, $email, $telefone, $rg, $cpf);

    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
    }

      return true;
  }

  public function cadastrar_paciente(Usuario $usuario, $nome, $email, $telefone, $rg, Datetime $nascimento)
  {
    try
    {
      $this->possui_funcionalidade($usuario, "Cadastrar paciente");
    }
    catch(Throwable $t)
    {
      $t->getMessage();
      return false;
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
      $t->getMessage();
      return false;
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
      $t->getMessage();
      return false;
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
      $t->getMessage();
      return false;
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
      $t->getMessage();
      return false;
    }
  }

  public function realizar_consulta(Paciente $paciente, string $data, Usuario $usuario)
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