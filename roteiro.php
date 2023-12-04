<?php 

require_once "global.php";


$perfil_admin = new Perfil("", array(), true);

$user = new Users("login", "senha", "email", "admin");

Facade::realizar_login("login", "senha");

/*Facade::criar_perfil("perfil_teste", 
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
  "cadastrar_dentista",
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
));*/


//Facade::criar_usuario("login_teste", "senha_teste", "email_teste", "perfil_teste");

Facade::realizar_logout();

Facade::realizar_login("login_teste", "senha_teste");



?>