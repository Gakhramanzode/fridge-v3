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
    <title>$user · подключение к телеграм-боту</title>
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

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
      <div class="box">
        <h2>Подлючиться к телеграм-боту</h2>
      <form action="turnOnTgBot.php?r=$randstr" method="post">
        <div class="form-group">
          <label for="tg_id">Ваш ID:</label>
          <input type="number" placeholder="Только цифры 🙏" min="0" name="tg_id">
        </div>
        <button type="submit" class="btn">Подключай уже</button>
      </form>
        <h2>Чтобы узнать свой ID:</h2>
          <ol>
            <li>Перейдите по <a href="https://t.me/fridge_asker_bot" target="_blank">ссылке</a> (она направит на самого бота)</li>
            <li>Отправьте команду <code>/myid</code></li>
            <li>Скопируйте цифры. Это и есть ваш ID. Введите его выше 👆</li>
          </ol>
        </div>
          <div class="GitHub">
            <a href="https://github.com/Gakhramanzode/fridge-v3" target="_blank">GitHub</a>
          </div>
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