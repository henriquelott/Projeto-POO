<?php
require_once "global.php"

class Horario extends persist
  {
    private $hora;
    private $minuto;

    function __construct ($hora,$minuto)
    {
      $this->hora = $hora;
      $this->minuto = $minuto;
    }

    public function get_hora()
    {
      return $this->hora;
    }

    public function get_minuto()
    {
      return $this->minuto;
    }

    public function get_horario_minutos()
    {
      return $this->hora*60 + $this->minuto;
    }

  }

  
?>