<?php
  $host = '31.31.196.165';    // Change as necessary
  $data = 'u1603907_publications';   // Change as necessary
  $username = 'u1603907_default';   // Change as necessary
  $pass = 'r11WsoLcvg6N7YsA';     // Change as necessary
  $chrs = 'utf8mb4';
  $attr = "mysql:host=$host;dbname=$data;charset=$chrs";
  $opts =
  [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  try
  {
    $pdo = new PDO($attr, $username, $pass, $opts);
  }
  catch (PDOException $e)
  {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
  }

  function createTable($name, $query)
  {
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
    echo "Таблица '$name' создана или уже существует.<br>";
  }

  function queryMysql($query)
  {
    global $pdo;
    return $pdo->query($query);
  }

  function destroySession()
  {
    $_SESSION=array();

    if (session_id() != "" || isset($_COOKIE[session_name()]))
      setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
  }

  function showProfile($username)
  {
    global $pdo;

    if (file_exists("$username.jpg"))
      echo "<img src='$username.jpg' style='float:left;'>";

    $result = $pdo->query("SELECT * FROM profiles WHERE user='$username'");

    while ($row = $result->fetch())
    {
      die(stripslashes($row['text']) . "<br style='clear:left;'><br>");
    }

    echo "<p>Здесь пока не на что смотреть</p><br>";
  }

?>
