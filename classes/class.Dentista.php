<?php
  require_once "global.php";

  class Dentista extends Funcionario
  {
    protected static $local_filename = "Dentista.txt";
    private $cro;
    private Especialidade $especialidades = array();
    private Agenda $agenda;
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, Especialidade $especialidade, Data $datas_disponiveis, Data $datas_marcadas)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
      
      $this->cro = $cro;
      $this->cadastrar_especialidade($especialidade);
      $this->criar_agenda($datas_disponiveis, $datas_marcadas);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function get_especialidade()
    {
      return $this->especialidades;
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
      if(count($datas_marcadas) != 0)
      {
        $today = getdate();
        foreach($datas_marcadas as $datas)
        {
          if(today->tm_mday != $datas->)
        }
      }
      else
      {
        $this->agenda = new Agenda ($datas_disponiveis);
      }
    }
    public function editar_agenda()
    {
      $comando; //ler comando
      $this->agenda->editar_agenda($comando);
    }

    public function get_agenda()
    {
      return &$this->agenda;
    }
  }

?>
