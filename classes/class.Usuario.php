<?php
  require_once "global.php";

  class Usuario extends persist
  {
    protected static $local_filename = "Usuario.txt";
    protected $login;
    protected $senha;
    protected $email;
    protected Perfil $perfil;
    protected static ?Usuario $instance;
  
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
    
    static function construct($login, $senha, $email, $perfil) : ?Usuario
    {
      if (!isset(self::$instance)) 
      {
        self::$instance = new static($login, $senha, $email, $perfil);
        return self::$instance;
      }

      return null;
    }

    static function get_instance()
    {
      return self::$instance;
    }

    public function editar_informacoes(string $atributo, string $valor)
    {
      switch $atributo
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

    public function get_login()
    {
      return $this->login;
    }

    public function get_email()
    {
      return $this->email;
    }

    public function get_perfil()
    {
      return $this->perfil;
    }

  }

?> 