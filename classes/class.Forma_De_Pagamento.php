<?php
require_once "global.php";

abstract class Forma_De_Pagamento extends persist
  {
    protected static $local_filename = "Forma_De_Pagamento.txt";
    protected $forma_pagamento;

    function construct ($forma_pagamento)
    {
      $this->formaPagamento = $forma_pagamento;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    abstract public function calcular_valor($valortotal)
    {
      
    }
    
    public function get_forma_pagamento()
    {
      return $this->forma_pagamento;
    }
  }

?>