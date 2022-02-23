<?php
  session_start();
  require_once 'header.php';

  echo "<div class='center'>Добро пожаловать на сайт,";

  if ($loggedin) echo " $user, вы залогинены";
  else           echo ' пожалуйста, войдите или зарегистрируйтесь';

  echo <<<_END
      </div><br>
    </div>
    <div data-role="footer">
      <h4>По всем вопросам и предложениям <i><a href='https://t.me/asker'
      target='_blank'>мой телеграм</a></i></h4>
    </div>
  </body>
</html>
_END;
?>