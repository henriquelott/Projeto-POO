<?php

require_once "global.php";

  class Agenda extends persist
  {
    protected static $local_filename = "Agenda.txt";
    protected array $datas_disponiveis = array();
    protected array $datas_marcadas = array();
    protected array $agenda_padrao = array();

    function __construct(array $agenda, string $mes)
    {
      $this->datas_marcadas = array();
      $this->agenda_padrao = $agenda;
      $this->datas_disponiveis = array();
      $this->construir_agenda_padrao($agenda, $mes);
    }

    public function construir_agenda_padrao(array $agenda, string $mes)
    {
      unset($this->datas_disponiveis);
      $this->agenda_padrao = $agenda;
      $intervalo = DateInterval::createFromDateString("1 day");
      $data_iterador = new DateTime(date('Y') . "-$mes-01");
      $array = array();

      for ((int)$data_iterador->format("d"); ((int)$data_iterador->format("d")) < ((int)$data_iterador->format("t")); $data_iterador->add($intervalo))
      {
        if(!empty($agenda[((int)$data_iterador->format("w"))]))
        {
          $data_inicio = new DateTime($data_iterador->format("Y") . "-" . $mes ."-". $data_iterador->format("d") . " " . $agenda[((int)$data_iterador->format("w"))][0]);
          $data_fim = new DateTime($data_iterador->format("Y") . "-" . $mes ."-". $data_iterador->format("d") . " " . $agenda[((int)$data_iterador->format("w"))][1]);
          $data = new Data($data_inicio, $data_fim);
          $this->datas_disponiveis[] = $data;
        }
      }
     // var_dump($this->datas_disponiveis);
      //$this->datas_disponiveis = $array;
      $this->save();
    }

    public function atualizar_agenda()
    {
      $data = new DateTime("now");
      $mes = $data->format("m");
      $this->construir_agenda_padrao($this->agenda_padrao, $mes);
    }
    
    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }
    
    public function editar_agenda(string $comando, Data $parametro)
    {
      $this->$comando($parametro);
    }

    public function cadastrar_consulta(Data $data)
    {
      $data_inicio = $data->get_data_inicio();
      $data_fim = $data->get_data_fim();
      
      foreach($this->datas_marcadas as $data_agenda)
      {
        $data_agenda_inicio = $data_agenda->get_data_inicio();
        $data_agenda_fim = $data_agenda->get_data_fim();

        if($data_inicio->format('Y-m-d') == $data_agenda_inicio->format('Y-m-d'))
        {
          if(($data_inicio >= $data_agenda_inicio && $data_inicio <= $data_agenda_fim) || ($data_fim >= $data_agenda_inicio && $data_fim <= $data_agenda_fim))
          {           
            throw(new Exception("\nJá existe uma consulta marcada com este dentista para esta data e horário\n"));
          }
        }
      }

      foreach ($this->datas_disponiveis as $data_agenda)
      {
        $data_agenda_inicio = $data_agenda->get_data_inicio();
        $data_agenda_fim = $data_agenda->get_data_fim();

        if($data_inicio->format('Y-m-d') == $data_agenda_inicio->format('Y-m-d')) 
        {
          if($data_inicio >= $data_agenda_inicio && $data_fim <= $data_agenda_fim)
          {
            array_push($this->datas_marcadas, $data);
            $this->save();

            return;
          }
        }
      }

      throw (new Exception ("\nData e horário indisponíveis\n"));
    }

    /*public function desmarcar_consulta($data)
    {
      if (($key = array_search($data, $this->datas_marcadas)) !== NULL)
      {
        $this->remover_data($data, $this->datas_marcadas);
        $this->adicionar_data($data, $this->datas_disponiveis);
      }
      else
      {
        throw(new Exception("\nConsulta nao encontrada\n"));
      }
    }*/

    public function adicionar_data(Data $data)
    {
      array_push($this->datas_disponiveis, $data);
      $this->save();
    }

    /*public function remover_data($data)
    {
      $data_inicio = $data->get_data_inicio();
      $data_fim = $data->get_data_fim();

      foreach($this->datas_disponiveis as $data_disponivel)
      {
        $data_disponivel_inicio = $data_disponivel->get_data_inicio();
        $data_disponivel_fim = $data_disponivel->get_data_fim();

        if($data_inicio->format('Y-m-d') == $data_agenda_inicio->format('Y-m-d'))
        {

        }
      }
    }*/

    public function &get_datas_marcadas()
    {
      return $this->datas_marcadas;
    }

    public function &get_datas_disponiveis()
    {
      return $this->datas_disponiveis;
    }
  }

?>



