<?php 

require_once "global.php";

/*$data = '2000-3-12';
$duracao_minutos = 14000;
$data_inicio = new DateTime($data);
$interval = DateInterval::createFromDateString("$duracao_minutos minutes");
$data_fim = $data_inicio->add($interval);

var_dump($data_fim);*/

$perfil = new Perfil("admin", 
array (
"criar_perfil",
"criar_usuario",
"cadastrar_orcamento",
"aprovar_orcamento",
"cadastrar_consulta_avaliacao",
"cadastrar_consulta",
"editar_agenda",
"editar_informacoes",
"cadastrar_auxiliar", 
"cadastrar_secretaria",
"cadastrar_dentista_funcionario",
"cadastrar_dentista_parceiro",
"cadastrar_cliente", 
"cadastrar_paciente",
"cadastrar_procedimento",
"criar_procedimento",
"criar_especialidade",
"cadastrar_especialidade",
"realizar_pagamento"));

$user = new Users("login", "senha", "email", $perfil);

Facade::realizar_login("login", "senha");

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

/*$array = array(array('14:00', '16:30'));

$mes = "2";

$ano = date("Y");

$data = new DateTime(date('Y') . "-$mes-01");

//var_dump((int)$data->format('w'));

$array = array(array(), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array("08:00","16:00"), array());

$agenda = new Agenda($array, $mes);

$agenda->construir_agenda_padrao($array, $mes);

/*$data_inicio = new DateTime($data->format("Y") . "-" . $mes ."-". $data->format("d") . " " . $array[((int)$data->format("w"))][0]);
$data_fim = new DateTime($data->format("Y") . "-" . $mes ."-". $data->format("d") . " " . $array[((int)$data->format("w"))][1]);
$data = new Data($data_inicio, $data_fim);
       
var_dump($data);

/*function funciones(array $agenda, string $mes)
{
  unset($datas_disponiveis);
  $agenda_padrao = $agenda;
  $intervalo = DateInterval::createFromDateString("1 day");
  $data_iterador = new DateTime(date('Y') . "-$mes-01");

  for ((int)$data_iterador->format("d"); ((int)$data_iterador->format("d")) < ((int)$data_iterador->format("t")) ; $data_iterador->add($intervalo))
  {
    if(!empty($agenda[((int)$data_iterador->format("w"))]))
    {
      $data_inicio = new DateTime($data_iterador->format("Y") . "-" . $mes ."-". $data_iterador->format("d") . " " . $agenda[((int)$data_iterador->format("w"))][0]);
      $data_fim = new DateTime($data_iterador->format("Y") . "-" . $mes ."-". $data_iterador->format("d") . " " . $agenda[((int)$data_iterador->format("w"))][1]);
      $data = new Data($data_inicio, $data_fim);
    }
    array_push($datas_disponiveis, $data);
  }

  return $datas_disponiveis;
}

$datas_disponiveis = funciones($array, $mes);*/

?>