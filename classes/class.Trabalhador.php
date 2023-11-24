<?php
  require_once "global.php";

  abstract class Trabalhador extends Pessoa
  {
    protected static $local_filename = "Trabalhador.txt";
    protected $cpf;
    protected bool $is_funcionario;
    protected Endereco $endereco;

    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, bool $is_funcionario)
    {
      parent::__construct($nome, $email, $telefone);

      $this->cpf = $cpf;
      $this->endereco = new Endereco($rua, $numero, $bairro, $complemento, $cep);
      $this->is_funcionario = $is_funcionario;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function get_is_funcionario()
    {
      return $this->is_funcionario;
    }
  }

?>