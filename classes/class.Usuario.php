<?php
  require_once "global.php";

  class Usuario extends persist
  {
    protected static $local_filename = "Usuario.txt";
    protected string $login;
    protected string $senha;
    protected string $email;
    protected Perfil $perfil;
    protected static ?Usuario $instance = NULL;
  
    private function __construct(string $login, string $senha, string $email, Perfil $perfil)
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
    
    static function construct($login, $senha, $email, $perfil) : ?Usuario
    {
      if (!isset(self::$instance)) 
      {
        self::$instance = new static($login, $senha, $email, $perfil);
        return self::$instance;
      }

      return self::$instance;
    }

    static function get_instance()
    {
      return self::$instance;
    }

    public function editar_informacoes(string $atributo, string $valor)
    {
      switch ($atributo)
      {
        case "login":
          $this->login = $valor;
          break;

        case "senha":
          $this->senha = $valor;
          break;

        case "email":
          $this->email = $valor;
          break;

        default:
          throw (new Exception("\nAtributo inválido\n"));
      }
    }

    public function get_login() : string
    {
      return $this->login;
    }

    public function get_senha() : string
    {
      return $this->senha;  
    }

    public function get_email() : string
    {
      return $this->email;
    }

    public function get_perfil() : Perfil
    {
      return $this->perfil;
    }

  }

?> 