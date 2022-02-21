<?php
session_start();

echo <<<_INIT
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
</html>
_INIT;

require_once 'functions.php';

$userstr = 'Добро пожаловать';
$randstr = substr(md5(rand()), 0, 7);

if (isset($_SESSION['user']))
{
  $user     = $_SESSION['user'];
  $loggedin = TRUE;
  $userstr  = "Профиль: $user";
}
else $loggedin = FALSE;

if ($loggedin)
{
  $date = date('Y-m-d');
  echo <<<_LOGGEDIN
  <title>Мой список продуктов</title>
  <h1>Список твоих продуктов</h1>

  Сегодняшняя дата: $date
  <hr>
  _LOGGEDIN;
  require_once 'loginDB.php';

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");
  
  $query = "SELECT Name,ExpirationDate from $user order by ExpirationDate";
//   if (!$query) die ("Невозможно подключиться ");
  $result = mysqli_query($db_server, $query);
  if (!$result) die ("Невозможно подключиться ");

  echo "<h2>Ваш список продуктов</h2>";
  
  echo "<ol>\n";
  while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "<li>\n";
      foreach ($line as $col_value) {
          echo "$col_value\t";
      }
      echo "</li>\n";
  }
  echo "</ol>\n";

  echo "<hr>";
  
  echo "<h2>Добавить продукт в список</h2>";
  
  echo '<form action="mysql.php" method="post">
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
  </form>';

  echo "<hr>";
  
  echo "<h2>Удалить продукт из списка</h2>";
  
  echo '<form action="delete.php" method="post">
  <p>
      <label for="Name">Наименование продукта:</label>
      <input type="text" name="Name">
  </p>
  <input type="submit" value="Удалить продукт">
  <br>
  <br>
  <nav>
  <a data-role="button" data-inline="true" data-icon="action"
    data-transition="slide" href="logout.php?r=$randstr">Выйти</a>
  </nav>';
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