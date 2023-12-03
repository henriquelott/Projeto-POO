 <?php 
require_once "global.php";

class Detalhe_Procedimento extends persist
  {
    protected static $local_filename = "Detalhe_Procedimento.txt";
    protected string $detalhamento_procedimento;
    protected $orcamentos = array();

    function __construct($detalhamento_procedimento)
    {
      $this->detalhamento_procedimento = $detalhamento_procedimento;
    }

    static public function getFilename()
    {
      return get_called_class()::$local_filename;
    }

    public function adicionar_orcamento(Orcamento $orcamento)
    {
      array_push($this->orcamentos, $orcamento);
    }

    public function get_detalhamento()
    {
      return $this->detalhamento_procedimento;
    }
  }

?>