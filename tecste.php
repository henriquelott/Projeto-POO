<?php 

require_once "global.php";

/*$data = '2000-3-12';
$duracao_minutos = 14000;
$data_inicio = new DateTime($data);
$interval = DateInterval::createFromDateString("$duracao_minutos minutes");
$data_fim = $data_inicio->add($interval);

var_dump($data_fim);

$lista_especialidades = new Lista_Especialidades();
$lista_especialidades->save();

$lista_procedimentos = new Lista_Procedimentos();
$lista_procedimentos->save();

$procedimentos = array (new Procedimento("descricao", "tipo_procedimento", 100, "detalhe"));

$especialidades = array(new Especialidade("especialidade", $procedimentos, 10));

Facade::criar_procedimento($procedimentos[0]);

Facade::criar_especialidade($especialidades[0]);

$array_especialidades = array(new Especialidade("especialidade", $procedimentos, 10));

$dentista = new Dentista_Funcionario("Roberval", "robs@gmail.com", "15997763823", "39102060850", "Flor de  Fogo", "65", "Liberdade", "Village", "31270217", "XXX", $array_especialidades, $lista_especialidades);
$dentista->save();

$paciente = new Paciente("Paciente", "email", "telefone", "rg", "2000-3-12");
$paciente->save();

$orcamento = new Orcamento($paciente, $dentista, $procedimentos);
$orcamento->save();

Facade::aprovar_orcamento($orcamento,"Cartão de débito");

$orcamentor = Orcamento::getRecordsByField("paciente", $paciente);

$orcamentor[0]->save();

$orcamentor[0]->save();

$orcamentor[0]->save();

$orcamentor[0]->save();

$orcamentor[0]->save();

var_dump($orcamentor);*/

Facade::criar_perfil("FUDIAD", array ("criar_usuario", "criar_perfil", "aprovar_orcamento"));

$perfil = Perfil::getRecords();

Facade::criar_perfil("FUDIAD", array ("criar_usuario", "criar_perfil", "aprovar_orcamento"));
?>