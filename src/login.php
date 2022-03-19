<?php
  require_once 'header.php';
  $error = $user = $pass = ""; 

  if (isset($_POST['user']))
  {
    $user = strtolower($_POST['user']);
    $pass = strtolower($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = '<strong color=>Не все поля были введены</strong>';
    else
    {
      $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");

      if ($result->rowCount() == 0)
      {
        $error = "Неверная попытка входа в систему";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die("<div class='center'>Теперь вы вошли в систему. Пожалуйста,
             <a data-transition='slide'
               href='header.php?view=$user&r=$randstr'>нажмите здесь,</a>
               чтобы продолжить. <br><br> <img src='img/WorldArt-256px-7.gif' alt='Фотография' width='128' height='128'> </div></div></body></html>");
      }
    }
  }

echo <<<_END
      <form method='post' action='login.php?r=$randstr'>
          <span class='error'>$error</span>
        <p>
          Пожалуйста, введите свои данные для входа в систему
        </p>
        <div>
          <label for="Name">Имя пользователя</label>
          <input type='text' maxlength='16' name='user' value='$user'>
        </div>
        
        <div>
          <label for="Password">Пароль</label>
          <input type='password' maxlength='16' name='pass' value='$pass'>
        </div>
          <input data-transition='slide' type='submit' value='Войти'>
      </form>
  </body>
</html>
_END;
?>