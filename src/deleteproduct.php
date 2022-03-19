<?php
  session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <title>Удаление продукта: $userstr</title>
  </head>
  <body>
    <h1>Список моих продуктов</h1></div>
    $userstr

_MAIN;
  
  if ($loggedin)
  {
  $date = date('Y-m-d');

echo <<<_LOGGEDIN
    <p>
        <a data-role='button' data-inline='true' data-icon='action'
          data-transition="slide" href='header.php?r=$randstr'>Список продуктов</a>
        <a data-role='button' data-inline='true' data-icon='action'
          data-transition="slide" href='addproduct.php?r=$randstr'>Добавить продукт</a>
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
    <h2>Удалить продукт из списка</h2>
      <p>
      <form action="delete.php?r=$randstr" method="post">
        <label for="Name">Наименование продукта: </label>
        <select name="select">
        <option disabled selected>Выберите продукт</option>
_LOGGEDIN;

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

  $query = "SELECT Name from $user order by ExpirationDate";
  $db_server->set_charset('utf8');

  $result = mysqli_query($db_server, $query);
  
  if (!$result) die ("Невозможно подключиться ");

  while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    foreach ($line as $col_value) {
      echo "\n\t\t\t<option value='$col_value'>$col_value</option>";
    };
  };

echo <<<_LOGGEDIN
      \n\t\t</select>
      </p>
      <input type="submit" value="Удалить продукт">
      </form>
  </body>
</html>
_LOGGEDIN;
    }
    else
    {
echo <<<_GUEST
    <div class="center">
        <a data-role="button" data-inline="true" data-icon="check"
        data-transition="slide" href="login.php?r=$randstr">Войти</a>
        <a data-role="button" data-inline="true" data-icon="plus"
        data-transition="slide" href="signup.php?r=$randstr">Регистрация</a>
    </div>
    <p class="info">(Вы должны войти в систему, чтобы использовать это приложение)</p>
  
_GUEST;
    }
?>