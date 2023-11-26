<?php
require_once "global.php";

class Data extends persist
{
  protected static $local_filename = "Data.txt";
  private DateTime $data_inicio;
  private DateTime $data_fim;
  

  function construct(DateTime $data_inicio, DateTime $data_fim)
  {
    $this->data_inicio = $data_inicio;
    $this->data_fim = $data_fim;
  }

  static public function getFilename()
  {
    return get_called_class()::$local_filename;
  }

}

?>

