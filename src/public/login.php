<?php
$host = 'mysql';
$user = 'user1';
$password = 's123';
$database = 'test';

$connect = mysqli_connect($host, $user, $password, $database);

// Обработчик формы входа
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    // Получаем данные пользователя из базы данных
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($connect, $query);
    $user = mysqli_fetch_assoc($result);

    // Проверяем, что пароль совпадает с хешем из базы данных
    if ($user && $password ==  $user['password']) {
        // Авторизуем пользователя
        session_start();
        $_SESSION['username'] = $user['username'];
        header('location: index.php');
        exit(); // Добавлено для прекращения выполнения скрипта после перенаправления
    } else {
        // Отображаем сообщение об ошибке
        $error = "Неверный логин или пароль";
    }
}
?>

<!-- Форма входа -->
<form method="get" action="index.php">
    <input type="submit" value="Вернуться на главную страницу">
</form>
<form method="get" action="register.php">
    <input type="submit" value="Регистрация">
</form>
<form method="post" action="login.php">
    <input type="text" name="username" placeholder="Имя пользователя" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit" name="login">Войти</button>
</form>

<?php if (isset($error)): ?>
    <p><?= $error ?></p>
<?php endif; ?>
