<?php

$date = date('Y-m-d');

echo "<title>Список продуктов</title>";
echo "<h1>Список твоих продуктов</h1>";
echo "Сегодняшняя дата: $date";
echo "<hr>";

require_once 'login.php';
$db_server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
if (!$db_server) die ("Невозможно подключиться ");

$query = 'SELECT Name,ExpirationDate from fridgev2 order by ExpirationDate';
$result = mysqli_query($db_server, $query);
if (!$result) die ("Невозможно подключиться ");

echo "<h2>Ваш список продуктов</h2>";

echo "<ol>\n";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    echo "<li>\n";
    foreach ($line as $col_value) {
        echo "$col_value\t";
    }
    echo "</li>\n";
}
echo "</ol>\n";

// // Освобождаем память от результата
// mysqli_free_result($result);

// // Закрываем соединение
// mysqli_close($db_server);
?>

<?php
echo "<hr>";

echo "<h2>Добавить продукт в список</h2>";

echo '<form action="mysql.php" method="post">
<p>
    <label for="Name">Наименование продукта:</label>
    <input type="text" name="Name">
</p>

<p>
    Выберите дату производства: <input type="date" name="ProductionDate">
</p>

<p>
    Выберите дату окончания срока действия: <input type="date" name="ExpirationDate">
</p>
    <input type="submit" value="Добавить продукт">
</form>';
?>

<?php
echo "<hr>";

echo "<h2>Удалить продукт из списка</h2>";

echo '<form action="delete.php" method="post">
<p>
    <label for="Name">Наименование продукта:</label>
    <input type="text" name="Name">
</p>
<input type="submit" value="Удалить продукт">';

?>