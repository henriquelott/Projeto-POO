<?php
  require_once "global.php";

  class Usuario extends persist
  {
    protected static $local_filename = "Usuario.txt";
    private $login;
    private $senha;
    private $email;
    private Perfil $perfil;
    
    static private Perfil $lista_perfis = array();
    static private Users $lista_usuarios = array();
    static private Perfil $lista_perfis = array();
    static private Orcamento $lista_orcamentos = array();
    static private Tratamento $lista_tratamentos = array();
    static private Lista_Taxas_Cartao $lista_taxas_cartao;
    static private Trabalhador $lista_dentistas = array();
    static private Lista_Especialidades $lista_especialidades;
    static private Lista_Procedimentos $lista_procedimentos;
    private static ?Usuario $instance;
  
    private function __construct($login, $senha, $email, $tipo_perfil)
    {
      $this->login = $login;
      $this->senha = $senha;
      $this->email = $email;
      $this->tipo_perfil = $perfil;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    private function __clone()
    {
      
    }

    public function __wakeup()
    {
       
    }

    static public function realizar_login($user, $pass)
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
    
    static function get_instance($login, $senha, $email, $tipo_perfil) : Usuario
    {
      if (!isset(self::$instance)) 
      {
        self::$instance = new static($login, $senha, $email, $tipo_perfil);
        return self::$instance;
      }

      return null;
    }

    public function get_tipo_perfil()
    {
      return $this->tipo_perfil;
    }

    public function criar_perfil($tipo_perfil, $funcionalidades)
    {
      if ($this->tipo_perfil->possui_funcionalidade($funcionalidade))
      {
        array_push($this->lista_perfis, new Perfil($tipo_perfil, $funcionalidades));
      }
      else
      {
        throw (new Exception("Este perfil não possui essa funcionalidade"));
      }
    }

    //$descricao, $tipo_procedimento, $preco, &$lista
    public function cadastrar_orcamento(Paciente $paciente, Trabalhador $dentista_responsavel, array $tipo_procedimentos)
    {
      
    }

    public function encontrar_procedimento(string $tipo_procedimento)
    {
      return $this->lista_procedimentos->get_procedimento_pelo_tipo($tipo_procedimento);
    }
    
    public function aprovar_tratamento()
    {
      
    }
    
    public function cadastrar_consulta_de_avaliacao()
    {
      
    }

    public function cadastrar_consulta()
    {
      
    }

    public function editar_agenda()
    {
      
    }

    public function editar_informacoes()
    {
      
    }

    public function cadastrar_auxiliar()
    {
      
    }

    public function cadastrar_secretaria()
    {
      
    }

    public function cadastrar_dentista()
    {
      
    }

    public function cadastrar_dentista_parceiro()
    {

    }

    public function cadastrar_cliente()
    {  
      
    }

    public function cadastrar_paciente()
    {
      
    }

    public function cadastrar_procedimento()
    {
      
    }

    public function criar_procedimento()
    {
      
    }
    
    public function cadastrar_especialidade()
    {
      
    }

    public function realizar_pagamento()
    {
      
    }

    public function criar_cadastro()
    {
      
    }
    
  }

?>