<?php 

require_once "global.php";

Facade::calcular_resultado_mensal();

var_dump(Usuario::get_instance());

$perfil = new Perfil(true);

$user = new Users("login", "senha", "email", "admin");

Facade::realizar_login("login", "senha");

$lista_especialidades = new Lista_Especialidades();
$lista_especialidades->save();

$lista_procedimentos = new Lista_Procedimentos();
$lista_procedimentos->save();

$lista_taxas = new Lista_Taxas_Cartao();
$lista_taxas->save();

$taxa_credito = array(0.04, 0.04, 0.04, 0.07, 0.07, 0.07);
$taxa_debito = 0.03;

$array_proc = array ("tipo_procedimento");

$procedimento = new Procedimento("descricao", "tipo_procedimento", 101, "detalhe");

$procedimentos = array ($procedimento);

$especialidades = array(new Especialidade("especialidade", $array_proc, 10)); 

Facade::criar_procedimento($procedimentos[0]);

Facade::criar_especialidade($especialidades[0]);

Facade::cadastrar_taxa_cartao($taxa_debito, $taxa_credito);

$dentista = new Dentista_Funcionario("Roberval", "robs@gmail.com", "15997763823", "39102060850", "Flor de  Fogo", "65", "Liberdade", "Village", "31270217", "XXX", $especialidades, 50000);

Facade::cadastrar_dentista_funcionario($dentista);

$cliente = new Cliente("Paciente", "email", "telefone", "rg", "2000-3-12");

$cliente->save(); 

$clientes = array($cliente);

$paciente = new Paciente("Paciente", "email", "telefone", "rg", "2000-3-12", $clientes);

Facade::cadastrar_paciente($paciente);

$agenda = array(array(), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array());

Facade::cadastrar_agenda_padrao($dentista, $agenda, "11");

Facade::cadastrar_consulta_de_avaliacao($dentista, $paciente, "2023-11-6 14:00:00");

//var_dump($paciente);

Facade::realizar_consulta("2023-11-6 14:00:00", $paciente);

//var_dump($paciente->get_consultas()[0]->get_data_inicio());

$orcamento = new Orcamento($paciente, $dentista, $procedimentos);

Facade::cadastrar_orcamento($orcamento);

Facade::aprovar_orcamento($orcamento,"Cartão de crédito", 2);

//var_dump($orcamento);

$tratamento = Tratamento::getRecordsByField("paciente", $paciente);

$tratamento = $tratamento[count($tratamento)-1];

Facade::cadastrar_consulta($tratamento, $procedimento, '2023-11-15 09:00:00', 100);

$formas_pagamento = array(array("Pix", 0.5), 3 => array("Cartão de crédito", 0.5));

Facade::realizar_pagamento($tratamento, $cliente, $formas_pagamento);

Facade::calcular_resultado_mensal();


?>