<?php
require_once "global.php";

class A_Vista extends Forma_De_Pagamento
  {
    protected static $local_filename = "A_Vista.txt";
    
    function __construct ($forma_pagamento)
    {
      parent::__construct($forma_pagamento);
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function calcular_valor($valortotal)
      {
        return $valortotal;
      }
  }

?>