<?php
  session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'> 

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
    <div data-role='page'>
      <div data-role='header'>
        <h1>Список моих продуктов</h1>
        <div class='username'>$userstr</div>
      </div>
      <div data-role='content'>

_MAIN;
  
  if ($loggedin)
  {
  $date = date('Y-m-d');
echo <<<_LOGGEDIN

        <div class='center'>
        <a data-role='button' data-inline='true' data-icon='action'
          data-transition="slide" href='logout.php?r=$randstr'>Выйти</a>
        </div>

  Сегодняшняя дата: $date

_LOGGEDIN;

    $db_server = mysqli_connect($host, $username, $pass, $data);
    if (!$db_server) die ("Невозможно подключиться ");
        
    $query = "SELECT Name,ExpirationDate from $user order by ExpirationDate";

    $result = mysqli_query($db_server, $query);
    if (!$result) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
    <h2>Ваш список продуктов</h2>
_LOGGEDIN;
    echo "<ol>\n";
    while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "<li>\n";
      foreach ($line as $col_value) {
        echo "$col_value\t";
      }
      echo "</li>\n";
    }
    echo "</ol>\n";

echo <<<_LOGGEDIN
    <hr>
      
    <h2>Добавить продукт в список</h2>
      
    <form action="mysql.php?r=$randstr" method="post">
    <p>
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

    <form action="delete.php?r=$randstr" method="post">
    <p>
      <label for="Name">Наименование продукта:</label>
      <input type="text" name="Name">
    </p>
    <input type="submit" value="Удалить продукт"><br><br> </body></head>
_LOGGEDIN;
  }
  else
  {
echo <<<_GUEST
          <div class='center'>
          <a data-role='button' data-inline='true' data-icon='check'
          data-transition="slide" href='login.php?r=$randstr''>Войти</a>
            <a data-role='button' data-inline='true' data-icon='plus'
              data-transition="slide" href='signup.php?r=$randstr''>Регистрация</a>
          </div>
          <p class='info'>(Вы должны войти в систему, чтобы использовать это приложение)</p>

_GUEST;
  }
?>