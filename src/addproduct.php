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

  $db_server = mysqli_connect($host, $username, $pass, $data);
  if (!$db_server) die ("Невозможно подключиться ");

echo <<<_LOGGEDIN
      <div class="box">
      <div class="def-text">
        <h2>Добавить продукт в список</h2>
      </div>
          <form action="mysql.php?r=$randstr" method="post">
            <div class="form-group">
              <label for="Name">Наименование продукта:</label>
              <input type="text" name="Name">
            </div>
            <div class="form-group">
              <label for="date">Дата окончания срока годности:</label>
              <input type="date" name="ExpirationDate">
            </div>
            <button type="submit" class="btn">Добавить продукт</button>
          </form>
          </div>
        </div>
      </div>
          <div class="GitHub">
            <a href="https://github.com/Gakhramanzode/fridge-v3" target="_blank">GitHub</a>
          </div>
    </body>
</html>
_LOGGEDIN;
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