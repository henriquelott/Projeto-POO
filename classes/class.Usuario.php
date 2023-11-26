<?php
  require_once "global.php";

  class Usuario extends persist
  {
    protected static $local_filename = "Usuario.txt";
    private $login;
    private $senha;
    private $email;
    private Perfil $perfil;
    private static ?Usuario $instance;
  
    private function __construct($login, $senha, $email, $perfil)
    {
      $this->login = $login;
      $this->senha = $senha;
      $this->email = $email;
      $this->perfil = $perfil;
      $this->save();
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

    public function get_login()
    {
      return $this->login;
    }
    
    static function get_instance($login, $senha, $email, $perfil) : Usuario
    {
      if (!isset(self::$instance)) 
      {
        self::$instance = new static($login, $senha, $email, $perfil);
        return self::$instance;
      }

      return null;
    }

    public function get_perfil()
    {
      return $this->perfil;
    }

    public function get_tipo_perfil()
    {
      return $this->perfil->get_tipo_perfil();
    }
    
  }

?>