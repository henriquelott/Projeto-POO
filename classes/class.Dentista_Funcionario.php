<?php
  require_once "global.php";

  class Dentista_Funcionario extends Dentista
  {
    protected static $local_filename = "Dentista_Funcionario.txt";
    protected float $salario;
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, float $salario)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidades);
      $this->salario = $salario;
    }

    static public function getFilename()
    {
      return self::$local_filename;
    }

    public function get_salario()
    {
      return $this->salario;
    }
    
    public function calc_salario_comissao(?Procedimento $procedimento = NULL)
    {
      return $this->salario;
    }
  }


?>
