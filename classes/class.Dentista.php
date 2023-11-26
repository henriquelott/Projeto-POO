<?php
  require_once "global.php";

  class Dentista extends Funcionario
  {
    protected static $local_filename = "Dentista.txt";
    private $cro;
    private Especialidade $especialidades = array();
    private Agenda $agenda;
    
    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, string $especialidades = array(), Lista_Especialidades $lista)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
      
      $this->cro = $cro;
      $this->cadastrar_especialidade($especialidades, $lista);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function get_especialidade()
    {
      return $this->especialidades;
    }

    public function cadastrar_especialidade(string $nome_especialidade, Lista_Especialidades $lista)
    {
      $especialidade = $lista->encontrar_especialidade($nome_especialidade);
      array_push($especialidades, $especialidade);
    }

    public function criar_agenda(Data $datas_disponiveis, Data $datas_marcadas)
    {
      if(count($datas_marcadas) != 0)
      {
        $today = getdate();
        foreach($datas_marcadas as $datas)
        {
          
        }
      }
      else
      {
        $this->agenda = new Agenda ($datas_disponiveis);
      }
    }
    public function editar_agenda($comando)
    {
      $comando; //ler comando
      $this->agenda->editar_agenda($comando);
    }

    public function &get_agenda()
    {
      return $this->agenda;
    }
  }

?>
