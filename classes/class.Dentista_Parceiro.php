<?php

require_once "global.php";

class Dentista_Parceiro extends Dentista 
{
  protected static $local_filename = "Dentista_Parceiro.txt";
  protected float $comissao;

  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista);
    
    $this->comissao = 0.0;
    $this->save();
    
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function calc_comissao(Procedimento $procedimento)
  {
    foreach($this->especialidades as $especialidade)
      {
        foreach($especialidade->get_procedimentos_possiveis() as $procedimento_possivel)
          {
            if($procedimento_possivel == $procedimento)
            {
              $valor_comissao = $procedimento->get_valor() * $especialidade->get_percentual();
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

