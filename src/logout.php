<?php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    session_destroy();
    echo "Вы вышли из системы. Пожалуйста, <a data-transition='slide'href='index.php?r=$randstr'>нажмите здесь,</a> чтобы обновить экран.<br><br> <img src='img/WorldArt-256px-14.gif' alt='Фотография' width='128' height='128'>";
  }
  else echo "Вы не можете выйти из системы, потому что
              вы не вошли в систему";
?>
  </body>
</html>