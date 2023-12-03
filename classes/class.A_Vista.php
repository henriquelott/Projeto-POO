<?php
require_once "global.php";

class A_Vista extends Forma_De_Pagamento
  {
    protected static $local_filename = "A_Vista.txt";
    
    function __construct ($forma_pagamento)
    {
      parent::__construct($forma_pagamento);
      $this->calculo_desconto = new Desconto_A_Vista();
    }

    static public function getFilename()
    {
      return self::$local_filename;
    }

    public function calcular_valor($valortotal)
    {
      return this->$calculo_desconto->calcular_desconto($valortotal);
    }
  }

?>