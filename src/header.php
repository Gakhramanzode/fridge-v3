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
    <title>Список моих продуктов: $user</title>
  </head>
  <body>
      <div class="container">
        <h1>Список моих продуктов</h1>

_MAIN;
  
  if ($loggedin)
  {
  $date = date('Y-m-d');

echo <<<_LOGGEDIN
        <p>
          <a data-role='button' data-inline='true' data-icon='action'
            data-transition="slide" href='addproduct.php?r=$randstr'>Добавить продукт</a>
          <a data-role='button' data-inline='true' data-icon='action'
            data-transition="slide" href='deleteproduct.php?r=$randstr'>Удалить продукт</a>
          <a data-role='button' data-inline='true' data-icon='action'
            data-transition="slide" href='telegram.php?r=$randstr'>Телеграм-бот</a>
          <a data-role='button' data-inline='true' data-icon='action'
            data-transition="slide" href='logout.php?r=$randstr'>Выйти</a>
        </p>    
        <p>
          Сегодняшняя дата: $date
        </p>

_LOGGEDIN;

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
        <hr color="#db944e">
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
        <img src="img/BoysClub-256px-19.gif" alt="Фотография" width="128" height="128"><br>
      </div>
    </body>
</html>
_LOGGEDIN;
  }
  else
  {
echo <<<_GUEST
      <p>
        <a data-role="button" data-inline="true" data-icon="check"
        data-transition="slide" href="login.php?r=$randstr">Войти</a>
        <a data-role="button" data-inline="true" data-icon="plus"
        data-transition="slide" href="signup.php?r=$randstr">Регистрация</a>
      </p>

_GUEST;
  }
?>