<?php
require_once "global.php";

if(!isset($_SESSION)) {  
  session_start();
}

session_destroy();

//Usuario::sair();

header("Location: index.php");

?>