<?php
  session_start();
  require_once 'header.php';

  echo '      Добро пожаловать на сайт,';

  if ($loggedin) echo " $user, вы залогинены";
  else           echo ' пожалуйста, войдите или зарегистрируйтесь <br><br> <img src="img/WorldArt-256px-5.gif" alt="Фотография" width="128" height="128">';

  echo <<<_END
      <h4>По всем вопросам и предложениям <i><a href="https://t.me/asker" target="_blank">мой телеграм</a></i></h4>
  </body>
</html>
_END;
?>