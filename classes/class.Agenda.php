<?php

require_once "global.php"
  class Agenda extends persist
  {
    protected static $local_filename = "Agenda.txt";
    private Data $data_disponiveis = array();
    private Data $datas_marcadas = array();

    function __construct($datas_disponiveis, $datas_marcadas)
    {
      $this->datas_disponiveis = $datas_disponiveis;
      $this->datas_marcadas = $datas_marcadas; 
    }

    function construir_agenda_padrao($datas_disponiveis)
    {
      $this->datas_disponiveis = $datas_disponiveis;
      $this->datas_marcadas = array();
    }
    
    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
    
    public function editar_agenda(string $comando, Data $parametro)
    {
      switch ($comando)
      {
        case 'Cadastrar Consulta' :
          $this->cadastrar_consulta($parametro);
          break;

        case 'Desmarcar Consulta' :
          $this->desmarcar_consulta($parametro);
          break;

        case 'Adicionar Data' :
          $this->adicionar_data($parametro);
          break;

        case 'Remover Data'
          $this->remover_data($parametro);
          break;

        default: 
          throw(new Exception('Comando invalido'));
      }
    }

    public function cadastrar_consulta($data)
    {
      if(($key = array_search($data,$this->datas_marcadas)) !== NULL)
      {
        throw (new Exception ('Data ja cadastrada'));
      }
      else if (($key = array_search($data, $this->datas_disponiveis)) !== NULL)
      {
        $this->remover_data($data, $this->datas_disponiveis);
        $this->adicionar_data($data, $this->datas_marcadas);
      }
      else 
      {
        throw (new Exception ('Data indisponivel'));
      }
    }

    public function desmarcar_consulta($data)
    {
      if (($key = array_search($data, $this->datas_marcadas)) !== NULL)
      {
        $this->remover_data($data, $this->datas_marcadas);
        $this->adicionar_data($data, $this->datas_disponiveis);
      }
      else
      {
        throw(new Exception('Consulta nao encontrada'));
      }
    }

    public function adicionar_data($data, &$datas)
    {
      if (($key = array_search($data, $datas)) !== NULL) 
      {
        throw(new Exception('Data já cadastrada'));
      }
      else
      {
        array_push($datas, $data);
        $this->save();
      }
    }

     public function remover_data($data, &$datas)
      {
        if (($key = array_search($data, $datas)) !== NULL) 
        {
          unset($datas[$key]);
          $this->save();
        }
        else
        {
          throw(new Exception('Data nao encontrada'));
        }
      }

    public function get_datas_marcadas()
    {
      return &$this->datas_marcadas;
    }

    public function get_datas_disponiveis()
    {
      return &$this->datas_disponiveis;
    }
  }

?>



