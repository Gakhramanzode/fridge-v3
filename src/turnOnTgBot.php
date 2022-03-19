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
    <title>Подключение к телеграм-боту: $user</title>
  </head>
  <body>
      <h1>Список моих продуктов</h1>

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
        data-transition="slide" href='deleteproduct.php?r=$randstr'>Удалить продукт</a>
      <a data-role='button' data-inline='true' data-icon='action'
        data-transition="slide" href='telegram.php?r=$randstr'>Телеграм-бот</a>        
      <a data-role='button' data-inline='true' data-icon='action'
        data-transition="slide" href='logout.php?r=$randstr'>Выйти</a>
    </p>
    <p>
      Сегодняшняя дата: $date
    </p>
    <hr color="#db944e">

_LOGGEDIN;

$tg_id = $_POST['tg_id'];

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "UPDATE members SET tg_id = '$tg_id' WHERE user = '$user'";
$conn->set_charset('utf8');
if ($conn->query($sql) === TRUE) {
    echo "\t<p>\n\t\t👌 ID успешно добавлен. Вернитесь к телеграм-боту https://t.me/fridge_asker_bot, чтобы пользоваться сервисом в телеграмме.<br><br>
      <img src='img/PeopleMemes-256px-23.gif' alt='Фотография' width='128' height='128'><br>
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
      <p>
        <a data-role="button" data-inline="true" data-icon="check"
        data-transition="slide" href="login.php?r=$randstr">Войти</a>
        <a data-role="button" data-inline="true" data-icon="plus"
        data-transition="slide" href="signup.php?r=$randstr">Регистрация</a>
      </p>
      <p>
        (Вы должны войти в систему, чтобы использовать это приложение)
      </p>

_GUEST;
  }
?>