<?php 

require_once "global.php";

/*$data = '2000-3-12';
$duracao_minutos = 14000;
$data_inicio = new DateTime($data);
$interval = DateInterval::createFromDateString("$duracao_minutos minutes");
$data_fim = $data_inicio->add($interval);

var_dump($data_fim);*/

/*$lista_especialidades = new Lista_Especialidades();
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


//var_dump($orcamentor);








/*$data1 = new DateTime('2000-11-2 14:30:00');

$data2 = new DateTime('2000-11-2 23:30:00');

$dacta = array (new Data($data1, $data2));

$agenda = new Agenda($dacta);

$dota1 = new DateTime('2000-11-2 15:00:00');

$dota2 = new DateTime('2000-11-2 17:30:00');

$docta = new Data($dota1, $dota2);

$agenda->cadastrar_consulta($docta);

$dita1 = new DateTime('2000-11-2 16:00:00');

$dita2 = new DateTime('2000-11-2 18:00:00');

$dicta = new Data($dita1, $dita2);

try
{
  $agenda->cadastrar_consulta($dicta);
}
catch (Throwable $t)
{
  echo $t->getMessage();
}

$agengda = Agenda::getRecords();

$agengda[0]->save();

$agennda = Agenda::getRecords();

var_dump($agennda);*/

$array = array(array('14:00', '16:30'));

$mes = "2";

$ano = date("Y");

$data = new DateTime(date('Y') . "-$mes-01");

var_dump((int)$data->format('w'));


?>