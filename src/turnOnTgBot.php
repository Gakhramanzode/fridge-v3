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
    <title>Подключение к телеграм-боту: $user</title>
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
                <a href="header.php?r=$randstr">Список продуктов</a>
              </div>
              <div class="nav">
                <a href="addproduct.php?r=$randstr">Добавить продукт</a>
              </div>
              <div class="nav">
                <a href="deleteproduct.php?r=$randstr">Удалить продукт</a>
              </div>
              <div class="nav">
                <a href="logout.php?r=$randstr">Выйти</a>
              </div>
          </div>
        <div class="data">
          Сегодняшняя дата: $date
        </div>

_LOGGEDIN;

$tg_id = $_POST['tg_id'];

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "UPDATE members SET tg_id = '$tg_id' WHERE user = '$user'";
$conn->set_charset('utf8');
if ($conn->query($sql) === TRUE) {
    echo "<div class='box'>
          \t<p>\n\t\t👌 ID успешно добавлен. Вернитесь к <a href='https://t.me/fridge_asker_bot' target='_blank'>телеграм-боту</a>, чтобы пользоваться сервисом в мессенджере.
          </div>
          <img src='img/PeopleMemes-256px-23.gif' alt='Фотография' width='128' height='128'><br>
          <div class='GitHub'>
            <a href='https://github.com/Gakhramanzode/fridge-v3' target='_blank'>GitHub</a>
          </div>
        </div>
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