<?php
$host = 'mysql';
$user = 'user1';
$password = 's123';
$database = 'test';

$connect = mysqli_connect($host, $user, $password, $database);

// Обработчик формы регистрации
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Сохраняем данные пользователя в базе данных
    $query = "INSERT INTO users (username, password) 
              VALUES('$username', '$password')";
    mysqli_query($connect, $query);

    // Перенаправляем пользователя на страницу входа
    header('location: login.php');
    exit();
}
?>

<!-- Форма регистрации -->
<form method="get" action="index.php">
<input type="submit" value="Вернуться на главную страницу">
</form>
<form method="get" action="login.php">
<input type="submit" value="Aвторизация">
</form>
<form method="post" action="register.php">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" name="register">Зарегистрироваться</button>
</form>
