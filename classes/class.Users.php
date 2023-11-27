<?php
require_once "global.php";

class Users extends persist
  {
    protected static $local_filename = "Users.txt";
    public $login;
    public $senha;
    public $email;
    public Perfil $perfil;

    public function __construct($login, $senha, $email, $perfil)
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

    public function get_login()
    {
      return $this->login;
    }

    public function get_senha()
    {
      return $this->senha;
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