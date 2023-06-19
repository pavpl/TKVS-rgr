<?php
session_start();

// Получаем общую стоимость товаров в корзине
$total_price = isset($_POST['total_price']) ? $_POST['total_price'] : 0;

if (isset($_POST['pay'])) {
    echo "<p>Оплата прошла успешно! Спасибо за покупку!</p>";
    echo "<form method='get' action='index.php'>";
    echo "<input type='submit' value='Вернуться на главную страницу'>";
    echo "</form>";
    unset($_SESSION['cart']);
} else {
    // Отображаем форму ввода данных карты
    echo "<h2>Оплата</h2>";
    echo "<p>Общая стоимость: $total_price грн.</p>";
    echo "<form method='post' action='checkout.php'>";
    echo "<label>Номер карты:</label><br>";
    echo "<input type='text' name='card_number'><br>";
    echo "<label>Имя на карте:</label><br>";
    echo "<input type='text' name='card_name'><br>";
    echo "<label>Срок действия:</label><br>";
    echo "<input type='text' name='card_expiry'><br>";
    echo "<label>CVV:</label><br>";
    echo "<input type='text' name='card_cvv'><br><br>";
    echo "<input type='hidden' name='total_price' value='$total_price'>";
    echo "<input type='submit' name='pay' value='Оплатить'>";
    echo "</form>";
    echo "<form method='get' action='index.php'>";
    echo "<input type='submit' value='Вернуться на главную страницу'>";
    echo "</form>";
}
?>
