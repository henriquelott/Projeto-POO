<?php 

require_once "global.php";

/*$data = '2000-3-12';
$duracao_minutos = 14000;
$data_inicio = new DateTime($data);
$interval = DateInterval::createFromDateString("$duracao_minutos minutes");
$data_fim = $data_inicio->add($interval);

var_dump($data_fim);*/

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

/*$array = array(array('14:00', '16:30'));*/

/*$mes = "2";

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

/*$taxa_credito = array(0.04, 0.04, 0.04, 0.07, 0.07, 0.07);

$lista_taxas = new Lista_Taxas_Cartao();

$lista_taxas->cadastrar_taxa("Cartão de crédito", NULL, $taxa_credito);

$taxa1 = Lista_Taxas_Cartao::getRecords()[0];

$taxa1->save();

$taxa2 =Lista_Taxas_Cartao::getRecords();


var_dump($taxa2);*/

?>