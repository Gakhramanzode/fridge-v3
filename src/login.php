<?php
  require_once 'header.php';
  $error = $user = $pass = ""; 

  if (isset($_POST['user']))
  {
    $user = strtolower($_POST['user']);
    $pass = strtolower($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = '<strong>☝️ Не все поля были введены</strong>';
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
        die("<div class='box'>
               <div class='def-text'>Теперь вы вошли в систему. Пожалуйста,
               <a href='header.php?view=$user&r=$randstr'>нажмите здесь</a>, чтобы продолжить.
               </div>
             </div>
               <img src='https://storage.yandexcloud.net/tinmatch/WorldArt-256px-7.gif' alt='Фотография' width='128' height='128'>
            </body>
          </html>");
      }
    }
  }

echo <<<_END
      <div class='box'>
      <form method='post' action='login.php?r=$randstr'>
          <span>$error</span>
          <div class='def-text'>
            Введите свои данные для входа в систему:
          </div>
        <div class="form-group">
          <label for="Name">Имя пользователя</label>
          <input type='text' maxlength='16' name='user' value='$user'>
        </div>
        <div class="form-group">
          <label for="Password">Пароль</label>
          <input type='password' maxlength='16' name='pass' value='$pass'>
        </div>
          <button type="submit" class="btn">Войти</button>
      </form>
      </div>
        <div class="GitHub">
          <a href="https://github.com/Gakhramanzode/fridge-v3" target="_blank">GitHub</a>
        </div>
  </body>
</html>
_END;
?>