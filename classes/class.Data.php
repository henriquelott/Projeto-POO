<?php
require_once "global.php";

class Data extends persist
{
  protected static $local_filename = "Data.txt";
  protected DateTime $data_inicio;
  protected DateTime $data_fim;
  

  function __construct(DateTime $data_inicio, DateTime $data_fim)
  {
    $this->data_inicio = $data_inicio;
    $this->data_fim = $data_fim;
  }

  public function get_data_inicio()  :  DateTime
  {
    return $this->data_inicio;
  }

  public function get_data_fim()  :  DateTime
  {
    return $this->data_fim;
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

}

?>

