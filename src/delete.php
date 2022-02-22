<?php
echo "<title>Удаление Продукта</title>";

$Name = $_POST['Name'];

require_once 'loginDB.php';

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "DELETE FROM asker WHERE Name = '$Name'";
if ($conn->query($sql) === TRUE) {
    echo "<p>Поздравляю! Продукт успешно удален из вашего списка. Вернитесь назад, чтобы посмотреть обновленный список продуктов.</p>";
    // header('Location: /www/fridge-asker.site/header.php');
    echo '<a href="header.php">Вернуться назад</a>';
} else {
    echo "К сожалению, произошла ошибка: " . $sql. "<br>" . $conn->error;
    echo '<br><br><a href="header.php">Вернуться назад</a>';
}

$conn->close();
?>