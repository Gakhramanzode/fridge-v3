<?php

echo "<title>Продукт успешно добавлен</title>";

$Name = $_POST['Name'];
$ProductionDate = $_POST['ProductionDate'];
$ExpirationDate = $_POST['ExpirationDate'];

// $servername = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'publications';

require_once 'loginDB.php';

$conn = new mysqli($host, $username, $pass, $data);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "INSERT INTO asker(Name, ProductionDate, ExpirationDate) VALUES('$Name', '$ProductionDate', '$ExpirationDate')";

if ($conn->query($sql) === TRUE) {
    // echo "<p>Поздравляю! Продукт успешно добавлен в ваш список. Вернитесь назад, чтобы посмотреть обновленный список продуктов.</p>";
    header('Location: /src/header.php');
} else {
    echo "К сожалению, произошла ошибка: " . $sql. "<br>" . $conn->error;
}

$conn->close();

?>