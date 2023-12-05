<?php
require_once "global.php";

$cliente = new Cliente("","","","","");
$cliente->save();

$records = Cliente::getRecords();

var_dump($records);


?>