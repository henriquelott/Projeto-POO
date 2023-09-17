<?php
  require_once "global.php";
  
  class Usuario
  {
    private $login;
    private $senha;
    private $bancoDeDados;
  
    function __construct($login, $senha, &$bancoDeDados)
    {
      $this->login = $login;
      $this->senha = $senha;
      $this->bancoDeDados = $bancoDeDados;
    }

    public function cadastroCliente($nome, $email, $telefone, $rg, $cpf)
    {
      $this->bancoDeDados->cadastroCliente($nome, $email, $telefone, $rg, $cpf);
    }
  
    public function cadastroPaciente($nome, $email, $telefone, $rg, $nascimento)
    {
      $this->bancoDeDados->cadastroPaciente($nome, $email, $telefone, $rg, $nascimento);
    }
  
    public function cadastroDentistaParceiro($nome, $email, $telefone, $cro, $especialidade, $precoConsulta, $taxaComissao)
    {
      $this->bancoDeDados->cadastroDentistaParceiro($nome, $email, $telefone, $cro, $especialidade, $precoConsulta, $taxaComissao);
    }

    public function cadastroAuxiliar($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      $this->bancoDeDados->cadastroAuxiliar($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
    }

    public function cadastroDentista($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, $especialidade)
    {
      $this->bancoDeDados->cadastroDentista($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario, $cro, $especialidade);
    }

    public function cadastroSecretaria($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario)
    {
      $this->bancoDeDados->cadastroSecretaria($nome, $email, $telefone, $cpf, $rua, $numero, $bairro, $complemento, $cep, $salario);
    }

    
    public function confirmaPagamento()
    {
      
    }

  }

?>