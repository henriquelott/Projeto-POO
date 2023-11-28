<?php
  require_once "global.php";

  class Endereco extends persist
  {
    protected static $local_filename = "Endereco.txt";
    protected $rua;
    protected $numero;
    protected $bairro;
    protected $complemento;
    protected $cep;

    function __construct($rua, $numero, $bairro, $complemento, $cep)
    {
      $this->rua = $rua;
      $this->numero = $numero;
      $this->bairro = $bairro;
      $this->complemento = $complemento;
      $this->cep = $cep;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function get_rua()
    {
      return $this->rua;
    }

    public function get_numero()
    {
      return $this->numero;
    }

    public function get_bairro()
    {
      return $this->bairro;
    }

    public function get_complemento()
    {
      return $this->complemento;
    }

    public function get_cep()
    {
      return $this->cep;
    }
  }

?>