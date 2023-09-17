<?php
  require_once "global.php";

  class BancoDeDados
  {
    private $clientes = array();
    private $pacientes = array();
    private $dentistasParceiros = array();
    private $auxiliares = array();
    private $dentistas = array();
    private $secretarias = array();

    function __construct()
    {
        
    }

    public function cadastroCliente($nome, $email, $telefone, $rg, $cpf)
    {
      array_push($this->clientes, new Cliente($nome, $email, $telefone, $rg, $cpf));
    }
  
    public function cadastroPaciente($nome, $email, $telefone, $rg, $nascimento)
    {
      array_push($this->pacientes, new Paciente($nome, $email, $telefone, $rg, $nascimento));
    }
  
    public function cadastroDentistaParceiro($nome, $email, $telefone, $cro, $especialidade, $precoConsulta, $taxaComissao)
    {
      array_push($this->dentistasParceiros, new DentistaParceiro($nome, $email, $telefone, $cro, $especialidade, $precoConsulta, $taxaComissao));
    }

    public function cadastroAuxiliar($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      array_push($this->auxiliares, new Auxiliar($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario));
    }

    public function cadastroDentista($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, $especialidade)
    {
      array_push($this->dentistas, new Dentista($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, $especialidade));
    }

    public function cadastroSecretaria($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      array_push($this->secretarias, new Secretaria($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario));
    }

}

?>