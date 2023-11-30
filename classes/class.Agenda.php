<?php

require_once "global.php";

  class Agenda extends persist
  {
    protected static $local_filename = "Agenda.txt";
    protected array $datas_disponiveis;
    protected array $datas_marcadas;

    function __construct(array $datas_disponiveis)
    {
      $this->construir_agenda_padrao($datas_disponiveis);
    }

    function construir_agenda_padrao(array $agenda, string $mes)
    {
      $intervalo = DateInterval::createFromDateString("1 day");
      $data1 = new DateTime(date('Y') . "-$mes-01");

      for ((int)$data1->format("w"); ((int)$data1->format("w")) < 7; $data1->add($intervalo))
      {

      }

      foreach($this->datas_disponiveis as $data_disponivel)
      {
        foreach($agenda as $dia_semana => $data_a_cadastrar)
        {
          $data1 = new DateTime(date('Y') . "-$mes-01");
        }
      }
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

    public function adicionar_data($data)
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



