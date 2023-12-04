<?php
  require_once "global.php";

  abstract class Dentista extends Trabalhador
  {
    protected static $local_filename = "Dentista.txt";
    protected $cro;
    protected array $especialidades;
    protected ?Agenda $agenda = NULL;


    function __construct($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $cro, array $especialidades)
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

      $this->especialidades[] = $especialidade;
      $especialidade->save();
      $this->save();
    }

    public function criar_agenda(array $agenda, string $mes_geracao_agenda)
    {       
      $this->agenda = new Agenda($agenda, $mes_geracao_agenda);
      $this->save();
    }
    public function editar_agenda($comando, $data)
    {
      $this->agenda->editar_agenda($comando, $data);
    }

    public function &get_agenda()
    {
      return $this->agenda;
    }

    public function cadastrar_consulta(Data $data)
    {
      if($this->agenda != NULL)
      {
        $this->agenda->cadastrar_consulta($data);
        $this->save();
      }
      else
      {
        throw (new Exception("\nO dentista $this->nome não possui agenda cadastrada\n"));
      }
    }

    abstract public function calc_salario_comissao(?Procedimento $procedimento);
  }
  ?>