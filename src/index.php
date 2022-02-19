<?php
require_once 'login.php';
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if (!$db_server) die ("Невозможно подключиться ");

// $query = "SELECT * from fridgev2";
$query = 'SELECT Name,ExpirationDate from fridgev2 order by ExpirationDate';
$result = mysqli_query($db_server, $query);
if (!$result) die ("Невозможно подключиться ");

echo "<table>\n";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// // Освобождаем память от результата
// mysqli_free_result($result);

// // Закрываем соединение
// mysqli_close($db_server);

echo '<form action="mysql.php" method="post">
<p>
    <label for="Name">Добавить продукт:</label>
    <input type="text" name="Name">
</p>

<p>
    Выберите дату производства: <input type="date" name="ProductionDate">
</p>

<p>
    Выберите дату окончания срока действия: <input type="date" name="ExpirationDate">
</p>
    <input type="submit" value="Отправить">
</form>'

?>