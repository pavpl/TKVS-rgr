<?php
session_start();

$host = 'mysql';
$user = 'user1';
$password = 's123';
$database = 'test';

$connect = mysqli_connect($host, $user, $password, $database);

// Инициализируем массив товаров в корзине
$cart_items = [];

// Если корзина не пуста, получаем информацию о товарах в корзине из базы данных
if (!empty($_SESSION['cart'])) {
    // Получаем id товаров из корзины
    $product_ids = array_column($_SESSION['cart'], 'id');

    // Получаем информацию о товарах из базы данных
    $query = "SELECT * FROM products WHERE id IN (" . implode(",", $product_ids) . ")";
    $result = mysqli_query($connect, $query);
    $cart_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Обработка удаления товара из корзины
if (isset($_POST['remove_product_id'])) {
    $product_id = $_POST['remove_product_id'];
    foreach ($_SESSION['cart'] as $key => $cart_item) {
        if ($cart_item['id'] == $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    header("Location: cart.php");
    exit();
}

// Обработка очистки корзины
if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
    exit();
}

// Отображаем все товары в корзине
$total_price = 0;
foreach ($cart_items as $cart_item) {
    // Получаем количество товара в корзине
    $quantity = 0;
    foreach ($_SESSION['cart'] as $cart_item_session) {
        if ($cart_item_session['id'] == $cart_item['id']) {
            $quantity = $cart_item_session['quantity'];
            break;
        }
    }

    // Вычисляем стоимость товаров в корзине
    $price = $cart_item['price'] * $quantity;
    $total_price += $price;

    // Выводим информацию о товаре
    echo "<h3>{$cart_item['name']}</h3>";
    echo "<p>{$cart_item['description']}</p>";
    echo "<p>Цена: {$cart_item['price']} грн. x $quantity = $price грн.</p>";
    echo "<form method='post'>";
    echo "<input type='hidden' name='remove_product_id' value='{$cart_item['id']}'/>";
    echo "<input type='submit' value='Удалить из корзины'/>";
    echo "</form>";
}

// Добавляем скрытое поле с общей стоимостью товаров в корзине
echo "<form method='post' action='checkout.php'>";
echo "<input type='hidden' name='total_price' value='$total_price'/>";
// Выводим общую стоимость товаров в корзине
echo "<p>Общая стоимость: $total_price грн.</p>";

// Отображаем кнопки для оформления заказа
echo "<input type='submit' value='Оформить заказ'/>";
echo "</form>";

echo "<form method='get' action='index.php'>";
echo "<input type='submit' value='Вернуться на главную страницу'>";
echo "</form>";
?>
