<?php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    session_destroy();
    echo "<div class='box'>
            <div class='def-text'>Вы вышли из системы. Пожалуйста, <a href='index.php?r=$randstr'>нажмите здесь</a>, чтобы обновить экран.
            </div>
          </div>
            <img src='img/WorldArt-256px-14.gif' alt='Фотография' width='128' height='128'>";
  }
  else echo "Вы не можете выйти из системы, потому что
              вы не вошли в систему";
?>
  </body>
</html>