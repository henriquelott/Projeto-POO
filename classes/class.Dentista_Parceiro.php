<?php

require_once "global.php";

class Dentista_Parceiro extends Dentista 
{
  protected static $local_filename = "Dentista_Parceiro.txt";
  protected float $comissao;

  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $especialidades);
    
    $this->comissao = 0.0;
    $this->save();
    
  }

  static public function getFilename()
  {
    return self::$local_filename;
  }

  public function get_comissao()
  {
    return $this->comissao;
  }
  
  public function calc_salario_comissao(Procedimento $procedimento)
  {
    foreach($this->especialidades as $especialidade)
      {
        foreach($especialidade->get_procedimentos_possiveis() as $procedimento_possivel)
          {
            if($procedimento_possivel == $procedimento)
            {
              $valor_comissao = $procedimento->get_preco() * $especialidade->get_percentual();
              $this->comissao += $valor_comissao;
              $this->save();
              return;
            }
          }
      }
    throw(new Exception("Esse procedimento nao pode ter sido realizado por esse dentista pois ele nao possui a especialidade requisitada"));
  }
}

?>

