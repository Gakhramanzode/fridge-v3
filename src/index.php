<?php
  // session_start();
  require_once 'header.php';

  echo "
  <title>Вход</title>
  <div class='center'>Добро пожаловать,";

  if ($loggedin) echo " $user, вы залогинены";
  else           echo ' пожалуйста, войдите или зарегистрируйтесь';

//   echo <<<_END
//       </div><br>
//     </div>
//     <div data-role="footer">
//       <h4>Web App from <i><a href='https://github.com/RobinNixon/lpmj6'
//       target='_blank'>Learning PHP MySQL & JavaScript</a></i></h4>
//     </div>
//   </body>
// </html>
// _END;
?>
