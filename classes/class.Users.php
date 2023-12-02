<?php
require_once "global.php";

class Users extends persist
  {
    protected static $local_filename = "Users.txt";
    protected string $login;
    protected string $senha;
    protected string $email;
    protected Perfil $perfil;

    public function __construct(string $login, string $senha, string $email, Perfil $perfil)
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

    public function get_login()  :  string 
    {
      return $this->login;
    }

    public function get_senha()  :  string 
    {
      return $this->senha;
    }

    public function get_email()  :  string 
    {
      return $this->email;
    }

    public function &get_perfil()  :  Perfil 
    {
      return $this->perfil;
    }
  }
?>