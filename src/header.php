<?php
  session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywors" content="список продуктов">
    <meta name="description" content="Сервис, который умеет (еще учится) хранить список продуктов">
    <link rel="stylesheet" href="style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

_INIT;

  require_once 'functions.php';

  $randstr = substr(md5(rand()), 0, 7);

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
  }
  else $loggedin = FALSE;

echo <<<_MAIN
    <title>$user · список моих продуктов</title>
  </head>
  <body>
      <div class="container">
        <h1>Список моих продуктов</h1>

_MAIN;
  
  if ($loggedin)
  {
  $date = date('Y-m-d');

echo <<<_LOGGEDIN
          <div class="group">
              <div class="nav">
                <a href='addproduct.php?r=$randstr'>Добавить продукт</a>
              </div>
              <div class="nav">
                <a href="deleteproduct.php?r=$randstr">Удалить продукт</a>
              </div>
              <div class="nav">
                <a href="telegram.php?r=$randstr">Телеграм-бот</a>
              </div>
              <div class="nav">
                <a href="logout.php?r=$randstr">Выйти</a>
              </div>
          </div>
        <div class='data'>
          Сегодняшняя дата: $date
        </div>

_LOGGEDIN;

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
        <div class="box">
          <h2>Ваш список продуктов</h2>

_LOGGEDIN;

  $a = mysqli_query($db_server, "SELECT COUNT(1) FROM $user");
  $b = mysqli_fetch_array( $a );

  if ($b[0] == 0)
      {
        echo "\t\t\t<p>Здесь пока пусто 🔍</p>\n";
      }
  else
      {
        $query = "SELECT Name, ExpirationDate from $user order by ExpirationDate";
        $db_server->set_charset('utf8');
    
        $result = mysqli_query($db_server, $query);
        if (!$result) die ("Невозможно подключиться ");
    
        echo "\t\t\t<ol>\n";
        while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          echo "\t\t\t\t<li>";
          foreach ($line as $col_value) {
            echo "$col_value ";
          };
          echo "</li>\n";
        };
        echo "\t\t\t</ol>\n";
      }

echo <<<_LOGGEDIN
        </div>    
      </div>
      <img src="img/BoysClub-256px-19.gif" alt="Фотография" width="128" height="128"><br>
      <div class="GitHub">
        <a href="https://github.com/Gakhramanzode/fridge-v3" target="_blank">GitHub</a>
      </div>
    </body>
</html>
_LOGGEDIN;
  }
  else
  {
echo <<<_GUEST
      <div class="group">
        <div class="nav">
          <a href='login.php?r=$randstr'>Войти</a>
        </div>
        <div class="nav">
          <a href='signup.php?r=$randstr'>Регистрация</a>
        </div>
      </div>

_GUEST;
  }
?>