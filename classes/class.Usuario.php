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
  
    private function __construct($login, $senha, $email)
    {
      $this->login = $login;
      $this->senha = $senha;
      $this->email = $email;
      //$this->perfil = $perfil;
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

        if($perfil[0]->senha == $pass) 
        {
          if(!isset($_SESSION)) {
             session_start();
          }
          //$_SESSION['Usuario'] = $user;

          $Usuario = Usuario::get_instance($perfil[0]->login, $perfil[0]->senha, $perfil[0]->email);
          $Usuario->save();

          header("Location: _painel.php");
          }
          echo "<script>alert('Usuário e/ou senha inválido(s), Tente novamente!');</script>";
      }
    }
    
    static function get_instance($login, $senha, $email, $perfil) : ?Usuario
    {
      if (!isset(self::$instance)) 
      {
        self::$instance = new static($login, $senha, $email, $perfil);
        return self::$instance;
      }

      return null;
    }

    public function get_login()
    {
      return $this->login;
    }

    public function get_perfil()
    {
      return $this->perfil;
    }
    
  }

?>