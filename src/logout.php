<?php // Example 12: logout.php
  require_once 'header.php';

  if (isset($_SESSION['user']))
  {
    destroySession();
    echo "<br><br><div class='center'>Вы вышли из системы. Пожалуйста,
         <a data-transition='slide'
           href='index.php?r=$randstr'>нажмите здесь,</a>
            чтобы обновить экран.</div>";
  }
  else echo "<div class='center'>Вы не можете выйти из системы, потому что
              вы не вошли в систему</div>";
?>
    </div>
  </body>
</html>
