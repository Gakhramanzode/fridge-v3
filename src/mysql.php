<?php
$Name = $_POST['Name'];
$ProductionDate = $_POST['ProductionDate'];
$ExpirationDate = $_POST['ExpirationDate'];

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'publications';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die ('Не удалось подключиться ' . $conn->connect_error);
}

$sql = "INSERT INTO fridgev2(Name, ProductionDate, ExpirationDate) VALUES('$Name', '$ProductionDate', '$ExpirationDate')";

if ($conn->query($sql) === TRUE) {
    echo "ДАННЫЕ ОТПРАВЛЕНЫ, АСКЕРЧИК";
} else {
    echo "Ошибка: " . $sql. "<br>" . $conn->error;
}

$conn->close();

echo '<br><br><a href="index.php">Вернуться назад</a>';

?>