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
    <title>$user · добавление продукта</title>
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
                <a href="deleteproduct.php?r=$randstr">Удалить продукт</a>
              </div>
              <div class="nav">
                <a href="telegram.php?r=$randstr">Телеграм-бот</a>
              </div>
              <div class="nav">
                <a href="logout.php?r=$randstr">Выйти</a>
              </div>
          </div>
        <div class="data">
          Сегодняшняя дата: $date
        </div>

_LOGGEDIN;

$Name = $_POST['Name'];
$ProductionDate = $_POST['ProductionDate'];
$ExpirationDate = $_POST['ExpirationDate'];
$type = $_POST['select'];

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "INSERT INTO $user (Name, ProductionDate, ExpirationDate, type) VALUES('$Name', '$ProductionDate', '$ExpirationDate', '$type')";
$conn->set_charset('utf8');
if ($conn->query($sql) === TRUE) {
    echo "<div class='box'>
          \t\n\t\t👌 Продукт успешно добавлен в ваш список. Вернитесь назад, чтобы посмотреть обновленный список продуктов.\n\t\n\t
          </div>
          <div class='btn-back'>
            <a href='header.php?r=$randstr'''>Вернуться назад</a>
          </div>
          <br>
          <img src='https://storage.yandexcloud.net/tinmatch/PeopleMemes-256px-2.gif' alt='Фотография' width='128' height='128'>
          <br>
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