<?php
  require_once "global.php";

  abstract class Dentista extends Trabalhador
  {
    protected static $local_filename = "Dentista.txt";
    protected $cro;
    protected array $especialidades;
    protected Agenda $agenda;


    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades, Lista_Especialidades $lista)
    {
      parent::__construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep);

      $this->cro = $cro;
      $this->especialidades = $especialidades;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function get_especialidades()
    {
      return $this->especialidades;
    }

    public function cadastrar_especialidade(Lista_Especialidades $lista, Especialidade &$especialidade)
    {
      $lista->especialidade_existe($especialidade);

      array_push($this->especialidades, $especialidade);
      $especialidade->save();
      $this->save();
    }

    public function criar_agenda(array $datas_disponiveis, array $datas_marcadas)
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
    public function editar_agenda($comando, $data)
    {
      $comando; //ler comando
      $this->agenda->editar_agenda($comando, $data);
    }

    public function &get_agenda()
    {
      return $this->agenda;
    }
  }
  ?>