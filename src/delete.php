<?php
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
    echo "Продукт успешно уделн из списка";
} else {
    echo "Ошибка: " . $sql. "<br>" . $conn->error;
}

$conn->close();

echo '<br><br><a href="index.php">Вернуться назад</a>';
?>