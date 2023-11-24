<?php

require_once "global.php";

class Dentista_Parceiro extends Trabalhador 
{
  protected static $local_filename = "Dentista_Parceiro.txt";
  private $cro;
  private Especialidade $especialidades = array()
  private Agenda $agenda;
  private double $comissao;

  function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, $preco_consulta)
  {
    parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, false);
    
    $this->cro = $cro;
    $this->comissao = 0.0;
    
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

  public function calc_comissao(Procedimento $procedimento)
  {
    double $valor_comissao;

    foreach($this->especialidades as $especialidade))
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
    throw(new Exception('Esse procedimento nao pode ter sido realizado por esse dentista pois ele nao possui a especialidade requisitada'));
  }

  public function cadastrar_especialidade(Especialidade $especialidade,Lista_Especialidades &$lista)
  {
    foreach($lista->get_especialidades_cadastradas() as $especialidade_cadastrada)
      {
        if($especialidade_cadastrada == $especialidade)
        {
          array_push($this->especialidades,$especialidade);
          return;
        }
      }
    throw(new Exception('Essa especialidade ainda nao foi cadastrada'));
  }

  public function criar_agenda(Data $datas_disponiveis, Data $datas_marcadas)
    {
      $this->agenda = new Agenda ($datas_disponiveis,$datas_marcadas);
    }

  public function editar_agenda()
  {
    $this->agenda->editar_agenda();
  }
  
  public function get_especialidades()
  {
    return $this->especialidades;
  }

  public function get_agenda()
  {
    return &$this->agenda;
  }
}

?>

