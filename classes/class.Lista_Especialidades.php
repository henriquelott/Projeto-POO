<?php
  require_once "global.php";

  class Lista_Especialidades extends persist
  {
    protected static $local_filename = "Lista_Especialidades.txt";
    protected Especialidade $especialidades = array();

    function __construct()
    {
      $this->especialidades = Especialidade::getRecords();
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function encontrar_especialidade($nome_especialidade)
    {
      foreach ($this->especialidades as $especialidade)
      {
        if ($especialidade->get_nome() == $nome_especialidade)
        {
          return $especialidade;
        }
      }
      throw(new Exception("A especialidade $nome_especialidade não foi cadastrada"));
    }

    public function get_especialidades_cadastradas()
    {
      return $this->especialidades;
    }

    public function cadastrar_especialidade($especialidade)
    {
      array_push($this->especialidades,$especialidade);
      $this->save();
    }
    
  }
?>