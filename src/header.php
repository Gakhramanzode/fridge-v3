<?php
  session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

_INIT;

  require_once 'functions.php';

  $userstr = 'Добро пожаловать гость';
  $randstr = substr(md5(rand()), 0, 7);

  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = "Профиль: $user";
  }
  else $loggedin = FALSE;

echo <<<_MAIN
    <title>Список моих продуктов: $userstr</title>
  </head>
  <body>
    <div data-role="page">
      <div data-role="header">
      <h1>Список моих продуктов</h1></div>
      <div class="username">$userstr</div>
    </div>
    <div data-role="content">

_MAIN;
  
  if ($loggedin)
  {
  $date = date('Y-m-d');

  echo <<<_LOGGEDIN
      <div class="center">
        <a data-role='button' data-inline='true' data-icon='action'
          data-transition="slide" href='logout.php?r=$randstr'>Выйти</a>
        </div>
      </div>
      <p>
        Сегодняшняя дата: $date
      </p>

_LOGGEDIN;

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
    <h2>Ваш список продуктов</h2>

_LOGGEDIN;

  $a = mysqli_query($db_server, "SELECT COUNT(1) FROM $user");
  $b = mysqli_fetch_array( $a );

  if ($b[0] == 0)
  {
    echo "      <p>Здесь пока пусто 🔍</p>\n";
  }
  else
  {
    $query = "SELECT Name,ExpirationDate from $user order by ExpirationDate";

    $result = mysqli_query($db_server, $query);
    if (!$result) die ("Невозможно подключиться ");

    echo "\t\t<ol>\n";
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "\t\t\t<li>";
      foreach ($line as $col_value) {
        echo "$col_value ";
      };
      echo "</li>\n";
    };
    echo "\t\t</ol>\n";
  };

echo <<<_LOGGEDIN
    <hr>
    <h2>Добавить продукт в список</h2>
      <p>
      <form action="mysql.php?r=$randstr" method="post">
        <label for="Name">Наименование продукта:</label>
        <input type="text" name="Name">
      </p>
      <p>
        Выберите дату производства: <input type="date" name="ProductionDate">
      </p>
      <p>
        Выберите дату окончания срока действия: <input type="date" name="ExpirationDate">
      </p>
        <input type="submit" value="Добавить продукт">
      </form>
    <hr>
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