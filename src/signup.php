<?php 
  require_once 'header.php';

echo <<<_END
  <script>
    function checkUser(user)
    {
      if (user.value == '')
      {
        $('#used').html('&nbsp;')
        return
      }

      $.post
      (
        'checkuser.php',
        { user : user.value },
        function(data)
        {
          $('#used').html(data)
        }
      )
    }
  </script>
_END;

  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) destroySession();

  if (isset($_POST['user']))
  {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if ($user == "" || $pass == "")
      $error = 'Не все поля были введены<br><br>';
    else
    {
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->rowCount())
        $error = 'Это имя пользователя уже существует<br><br>';
      else
      {
        queryMysql("INSERT INTO `members` (`user`, `pass`, `id`) VALUES ('$user', '$pass', NULL)");
        queryMysql("CREATE TABLE `u1603907_publications`.$user (
          `id` int(10) UNSIGNED NOT NULL,
          `Name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
          `ProductionDate` date DEFAULT NULL,
          `ExpirationDate` date DEFAULT NULL
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4");
        die('<h4>Аккаунт создан</h4>Пожалуйста, войдите в систему.</div></body></html>');
      }
    }
  }

echo <<<_END
      <form method='post' action='signup.php?r=$randstr'>$error
      <div data-role='fieldcontain'>
        <label></label>
        Пожалуйста, введите свои данные для регистрации
      </div>
      <div data-role='fieldcontain'>
        <label>Имя пользователя</label>
        <input type='text' maxlength='16' name='user' value='$user'
          onBlur='checkUser(this)'>
        <label></label><div id='used'>&nbsp;</div>
      </div>
      <div data-role='fieldcontain'>
        <label>Пароль</label>
        <input type='text' maxlength='16' name='pass' value='$pass'>
      </div>
      <div data-role='fieldcontain'>
        <label></label>
        <input data-transition='slide' type='submit' value='Зарегистрироваться'>
      </div>
    </div>
  </body>
</html>
_END;
?>