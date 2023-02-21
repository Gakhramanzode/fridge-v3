<?php
  session_start();
  require_once 'header.php';

  echo '<div class="box">
          <div class="def-text">
            Добро пожаловать на сайт, пожалуйста, войдите или зарегистрируйтесь
          </div>
        </div>
        <img src="https://storage.yandexcloud.net/tinmatch/WorldArt-256px-5.gif" alt="Фотография" width="128" height="128">
      </body>
    </html>';

  echo <<<_END
      <br>
      <div class="GitHub">
        <a href="https://github.com/Gakhramanzode/fridge-v3" target="_blank">GitHub</a>
      </div>
  </body>
</html>
_END;
?>