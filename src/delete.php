<?php
echo "<title>Продукт успешно удален</title>";

$Name = $_POST['Name'];

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'publications';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "DELETE FROM fridgev2 WHERE Name = '$Name'";

if ($conn->query($sql) === TRUE) {
    echo "<p>Поздравляю! Продукт успешно удален из вашего списка. Вернитесь назад, чтобы посмотреть обновленный список продуктов.</p>";
} else {
    echo "К сожалению, произошла ошибка: " . $sql. "<br>" . $conn->error;
}

$conn->close();

echo '<a href="header.php">Вернуться назад</a>';
?>