<?php
  require_once "global.php";
  $bancoDeDados = new BancoDeDados();
  $user = new Usuario('admin', 'admin', $bancoDeDados);
  
?>

<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Clínica Odontológica</title>
    <style type="text/css">
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      header {
        background-color: white;
        padding:8px 10px;
        text-align: center;
      }

      body {
        font-family: Arial, Helvetica, sans-serif;
        background-image: linear-gradient(45deg, cyan, yellow);
      }

      .telaLogin {
        background-color: rgba(100, 100, 100, 0.8);
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 50px;
        border-radius: 15px;
        color: #fff;
      }

      input {
        padding: 8px;
        border: none;
      }

      button {
        padding: 4px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <header>
      <h1><center>Clínica Odontológica</center></h1>
    </header>

    <div class="telaLogin">
      <h1><center>Login</center</h1>
      <br><br>
      <input type="text" placeholder="usuário">
      <br><br>
      <input type="password" placeholder="senha">
      <br><br>
      <button>entrar</button>
    </div>
    
  </body>
</html>