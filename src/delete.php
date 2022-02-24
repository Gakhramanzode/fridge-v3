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
    <title>Удаление продукта: $userstr</title>
  </head>
  <body>
    <div data-role="page">
      <div data-role="header">
        <h1>Удаление продукта</h1>
      </div>
      <div class="username">$userstr</div>
    </div>
    <div data-role="content">

_MAIN;

if ($loggedin)
{
$date = date('Y-m-d');
echo <<<_LOGGEDIN
    <div class="center">
      <a data-role="button" data-inline="true" data-icon="action"
        data-transition="slide" href="logout.php?r=$randstr">Выйти</a>
      </div>
    </div>
    <p>
      Сегодняшняя дата: $date
    </p>

_LOGGEDIN;

$Name = $_POST['select'];

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "DELETE FROM $user WHERE Name = '$Name'";
if ($conn->query($sql) === TRUE) {
    echo "\t<p>\n\t\tПоздравляю! Продукт успешно удален из вашего списка. Вернитесь назад, чтобы посмотреть обновленный список продуктов.\n\t</p>\n\t<a href='header.php?r=$randstr''>Вернуться назад</a>
  </body>
</html>";
    // header('Location: /www/fridge-asker.site/header.php');
} else {
    echo "К сожалению, произошла ошибка: " . $sql. "<br>
  </body>
</html>" . $conn->error;
}

$conn->close();
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