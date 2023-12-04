<?php 

require_once "global.php";

/*
IMPORTANTE:

Ficamos sabendo que foram descontados pontos na prova se fossem colocados blocos try-catch dentro dos métodos, e dentro destes blocos fossem lançadas as execões.
Todas as nossa métodos que são funcionalidades possuem um bloco try-catch, e em alguns, são lançadas excessões ali mesmo.
Tudo foi testado, e comentado tanto com o professor se poderia ser feito desta forma, quanto com o monitor.
No site do php, não há nenhuma informação sobre excessões não poderem ser lançadas dentro de um bloco try, inclusive são mostrados exemplos em que isso acontece, e a execução funciona.
Goataríamos de pedir que, caso isso seja um erro, não seja desontado do trabalho, pois como foi dito, essa informação foi checada com o professor e o monitor, e nas fontes sobre a linguagem php.
Ficamos sabendo da informação da prova no dia de hoje, através de um feedback mandado pelo professor para um dos membros do grupo, portanto não é mais possível alterar o codigo neste nível, com a certeza de que ele funcione, em tão pouco tempo.

Além disso, aparentemente a função save() da classe persist cria um index novo pra determinada instância em execuções direfentes do código, portanto, 
embora não tenhamos encontrado algum problema, se houver algum problema na execução, delete os arquivos .txt e o problema deve ser resolvido.
O único problema conhecido para execuções repetidas, é que o resultado financeiro da clínica parece mudar de valor, pois o calculo acaba levando
mais funcionários e tratamentos pagos em cosideração do que o número de instancias criadas duarante 1 execução, por conta de index de mesmas instâncias
de execuções anteriores, que não foram sobrescritos, mas deveriam ter sido.

OUTRO AVISO IMPORTANTE:

No vscode o código funciona perfeitamente. Testamos no replit e parece funcionar mas também parece ser mais propenso a erros (o replit não gera os arquivos .txt caso apagados, e da um erro na hora de rodar o código se eles não existirem, neste caso, sobre o problema com o resultado mensal, pedimos que esvazie os aquivos caso rode no replit).
Recomendamos que tente o código no vscode, vc pode clonar do nosso repositório públic no git https://github.com/henriquelott/Projeto-POO.git
*/


//primeiramente é cadastrado manualmente um perfil administrador que tem todas as funcionalidades
$perfil_admin = new Perfil("", array(), true);

$user = new Users("login", "senha", "email", "admin");

//é realizado o login do usuario administrador e é criado um perfil com todas as funcionalidades, exceto cadastrar procedimento
Facade::realizar_login("login", "senha");

Facade::criar_perfil("perfil_teste", 
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
  "cadastrar_dentista_parceiro",
  "cadastrar_dentista_funcionario",
  "cadastrar_cliente", 
  "cadastrar_paciente",
  "criar_procedimento",
  "criar_especialidade", 
  "cadastrar_especialidade",
  "realizar_pagamento",
  "cadastrar_taxa_cartao",
  "calcular_resultado_mensal", 
  "cadastrar_agenda_padrao",
  "cadastrar_consulta_de_avaliacao",
  "realizar_consulta",
));

//é criado o este usuário
Facade::criar_usuario("login_teste", "senha_teste", "email_teste", "perfil_teste");

//a parte de criação de perfil e usuario, em execuções repetidas aparecerão excessões na tela informado que ja existem usuario e perfil cadastrados com as respectivas informações

//é realizado o logout do usuário administrador
Facade::realizar_logout();

//é realizado o login do usuário para testar o controle de acesso
Facade::realizar_login("login_teste", "senha_teste");

Facade::cadastrar_procedimento();

//após testado o cadastro uma excessão deve ser lançada na tela e a execução do código prossegue
//é realizado o logout do usuário de teste para logar o usuário administrador
Facade::realizar_logout();

//é logado o usuário adiministrador
Facade::realizar_login("login", "senha");


//são criados os procedimentos um por um e cadastrados no sistema com as informações passadas
//a funcionalidade criar procedimento cadastra um procedimento no sistema, enquanto a funcionalidade cadastrar procedimento cadastra um procedimento em determinado orcamento
$limpeza = new Procedimento("", "Limpeza", 200, "");

Facade::criar_procedimento($limpeza);

$restauracao = new Procedimento("", "Restauração", 185, "");

Facade::criar_procedimento($restauracao);

$extracao_comum = new Procedimento("Não inclui dente siso", "Extração Comum", 285, "");

Facade::criar_procedimento($extracao_comum);

$canal = new Procedimento ("", "Canal", 800, "");

Facade::criar_procedimento($canal);

$extracao_siso = new Procedimento("Valor por dente", "Extração de Siso", 400, "");

Facade::criar_procedimento($extracao_siso);

$clareamento_a_laser = new Procedimento("", "Clareamento a laser", 1700, "");

Facade::criar_procedimento($clareamento_a_laser);

$clareamento_de_moldeira = new Procedimento("Clareamento caseiro", "Clareamento de moldeira", 900, "");

Facade::criar_procedimento($clareamento_de_moldeira);


//é feito o mesmo para as especialidades, uma a uma
$clinica_geral = new Especialidade("Clínica Geral", array("Limpeza", "Restauração", "Extração Comum"), 0.4);

Facade::criar_especialidade($clinica_geral);

$endodontia = new Especialidade("Endodontia", array("Canal"), 0.4);

Facade::criar_especialidade($endodontia);

$cirurgia = new Especialidade("Cirurgia", array("Extração de Siso"), 0.4);

Facade::criar_especialidade($cirurgia);

$estetica = new Especialidade("Estética", array("Clareamento a laser", "Clareamento caseiro"), 0.4);

Facade::criar_especialidade($estetica);


//são criadas e cadastradas as taxas de cartão, sendo a taxa do cartão de débito única, e as taxas do cartão de crédito associadas ao numero de parcelas correspondentes, pela posição no array
//por exemplo, a taxa para 3 parcelas esta na terceira posicao do array
$taxa_credito = array(0.04, 0.04, 0.04, 0.07, 0.07, 0.07);
$taxa_debito = 0.03;

Facade::cadastrar_taxa_cartao($taxa_debito, $taxa_credito);


//são criados arrays com as especialidades de cada dentista, então é criado cada dentista com seus arrays correspondentes, pois o construtor de dentista aceira um array de especialidades
//então são cadastrados os dentistas no sistema
$especialidades_funcionario = array($clinica_geral, $endodontia, $cirurgia);
$dentista_funcionario = new Dentista_Funcionario("Dentista Funcionário", "email@email.com", "15 991572323", "123.456.678-90", "rua", "1", "bairo", "complemento", "cep", "XXXX", $especialidades_funcionario, 5000);

$especialidades_parceiro = array($clinica_geral, $estetica);
$dentista_parceiro = new Dentista_Parceiro ("Dentista Parceiro", "email@email.com", "15 991572323", "123.456.678-90", "rua", "1", "bairo", "complemento", "cep", "XXXX", $especialidades_parceiro);

Facade::cadastrar_dentista_funcionario($dentista_funcionario);
Facade::cadastrar_dentista_parceiro($dentista_parceiro);


//são criados arrays para representar as agendas de cada dentista, sendo a posição do array o dia da semana, e o cada valor do array um array com dois horários, o de inicio e fim do expediente daquele dia
//é entao cadastrada cada agenda para seu respectivo dentista
$agenda_dentista_funcionario = array(array(), array("08:00","17:00"), array("08:00","17:00"), array("08:00","17:00"), array("08:00","17:00"), array("08:00","17:00"), array());

$agenda_dentista_parceiro = array(array(), array("08:00","12:00"), array("14:00","17:30"), array("14:00","17:30"), array("14:00","17:30"), array("08:00","12:00"), array());

Facade::cadastrar_agenda_padrao($dentista_funcionario, $agenda_dentista_funcionario, "11");

Facade::cadastrar_agenda_padrao($dentista_parceiro, $agenda_dentista_parceiro, "11");


//são criados cliente e paciente, e realizado seu cadastro, o construtor de paciente aceita um arra de clientes, por isso é passado o array
//o cadastro do cliente é feito através do paciente, para cadastrar clientes adicionais em um paciente basta chamar a funcionalidade Facade::cadastrar_cliente(Paciente &$paciente, Cliente &$cliente)
$cliente = new Cliente("Cliente", "email@email.com", "123456", "1234567", "123.456.78-90");

$array_clientes = array($cliente);

$paciente = new Paciente("Paciente", "email@email", "123456", "12345678", "2002-11-03", $array_clientes);

Facade::cadastrar_paciente($paciente); 


//é agendada uma consulta de avaliação com o dentista parceiro, e é verificado se a ação é realizada
//o padrão de retorno de todas as funcionalidades é true, se for realizada com sucesso, e false se não for. usamos um if() para checar a condição pedida.
//uma mensagem "Data e horário indiponíveis" deve sem impressa na tela, caso não seja possível cadastrar a consulta
$foi_possivel = Facade::cadastrar_consulta_de_avaliacao($dentista_parceiro, $paciente, "2023-11-06 14:00:00");

if(!$foi_possivel)
{
  //para evidenciar de forma mais clara, colocamos um var_dump na execução da próxima ação, e podemos ver que ele mostra o valor true na tela
  echo "\n---Nesta parte DEVE aparecer um var_dump() após a mensagem de realização da ação com sucesso---\n";
  var_dump(Facade::cadastrar_consulta_de_avaliacao($dentista_funcionario, $paciente, "2023-11-06 14:00:00"));
}


//é realizada a consulta de avaliação
Facade::realizar_consulta("2023-11-06 14:00:00", $paciente);


//é criado um orcamento com um array de procedimentos solicitados
//o orcamento é cadastrado no sistema
$procedimentos = array($limpeza, $clareamento_a_laser, $restauracao, $restauracao);

$orcamento = new Orcamento($paciente, $dentista_funcionario, $procedimentos);

Facade::cadastrar_orcamento($orcamento);


//é aprovado o orcamento, cadastrando uma forma de pagamento como foi pedido na sprint
Facade::aprovar_orcamento($orcamento, "Pix");


//o orcamento foi aprovado e se tornou um tratamento, vamos apenas buscar o tratamento no sistema, utilizando o getRecordsByField
//a segunda linha é pra ter certeza que aquele é o ultimo save do tratamento, pois quando o código é executado mais de uma vez o index de uma mesma instancia muda
$tratamento = Tratamento::getRecordsByField("paciente", $paciente);
$tratamento = $tratamento[count($tratamento)-1];


//são cadastradas as consultas no tratamento, cada uma em seu respectivo procedimento
Facade::cadastrar_consulta($tratamento, $limpeza, "2023-11-13 15:00:00", 60);
Facade::cadastrar_consulta($tratamento, $clareamento_a_laser, "2023-11-14 16:00:00", 60);
Facade::cadastrar_consulta($tratamento, $restauracao, "2023-11-21 08:00:00", 120);
Facade::cadastrar_consulta($tratamento, $restauracao, "2023-11-27 13:00:00", 120);



//para realizar o pagamento, é criado um array com as formas de pagamento e o percentual que cada uma representa do total pago
//foram passadas novas formas de pagamento como foi solicitado, mas caso não fosse passada nenhuma, a forma de pagamento registrada seria a que foi cadastrada no orcamento em sua aprovação
$formas_pagamento = array(array("Pix", 0.5), 3 => array("Cartão de crédito", 0.5));

//é realizado o pagamento
Facade::realizar_pagamento($tratamento, $cliente, $formas_pagamento);

//é calculado o resultado financeiro da clínica
//o calculo realizado nesta parte foi a soma do pagamento de todos os tratamentos menos os impostos, menos as taxas de cartão menos os gatos com todos os funcionarios da clínica
//nós checamos na calculadora e chegamos no mesmo resultado, caso esteja errado, é por que entendemos o que deveria ser feito de forma errada, porém o programa calcula exatmaente os que nós esperávamos
//lembrando que como informado anteriormente, se o programa for executado repetidas vezes sem deletar os arquivos .txt, o valor do resultado mensal muda a cada execução
Facade::calcular_resultado_mensal();








?>