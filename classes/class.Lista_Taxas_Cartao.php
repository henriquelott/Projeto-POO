<?php
require_once "global.php";

class Lista_Taxas_Cartao extends persist
{
  public static function getFilename()
  {
    return get_called_class()::$local_filename;
  }
    
}

?>