<?php
require_once "global.php";

class Consulta_Avaliacao extends Consulta
  {
    protected static $local_filename = "Consulta_Avaliacao.txt";

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    function __construct(Data $data_consulta, $dentista_responsavel, $duracao)
    {
      parent::__construct($data_consulta, $dentista_responsavel, $duracao);
    }
  }

?>