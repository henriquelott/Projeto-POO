<?php
  require_once "global.php";

  class Consulta extends persist
  {
    protected static $local_filename = "Consulta.txt";
    protected Data $data_consulta;
    protected $dentista_responsavel;
    protected $foi_realizada = false;

    function __construct(Data $data_consulta, $dentista_responsavel, $duracao)
    {
      $this->data_consulta = $data_consulta;
      $this->dentista_responsavel = $dentista_responsavel;
      $this->duracao = $duracao;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function consulta_realizada()
    {
      $this->foi_realizada = true;
    }

    public function get_dentista_responsavel()
    {
      return $this->dentista_responsavel;
    }

    public function get_data_consulta()
    {
      return $this->data_consulta;
    }

    public function get_foi_realizada()
    {
      return $this->foi_realizada;
    }

    public function get_duracao()
    {
      
    }

    public function get_data_inicio()
    {
      return $this->data_consulta->get_data_inicio();
    }

    public function cancelar_consulta_dentista()
    {
      $this->dentista_responsavel->get_agenda()->remover_data($this->data_consulta, $this->dentista_responsavel->get_agenda()->get_datas_marcadas());
    }

    public function cancelar_consulta_paciente()
    {
      $this->dentista_responsavel->get_agenda()->desmarcar_consulta($this->data_consulta);
    }
  }
  
?>