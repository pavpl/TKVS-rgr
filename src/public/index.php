<?php
session_start();

$host = 'mysql';
$user = 'user1';
$password = 's123';
$database = 'test';

$connect = mysqli_connect($host, $user, $password, $database);

// Получаем все товары из базы данных
$query = "SELECT * FROM products";
$result = mysqli_query($connect, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Обработчик добавления товара в корзину
if (isset($_POST['add_to_cart'])) {
    // Получаем id товара, который нужно добавить в корзину
    $product_id = $_POST['product_id'];

    // Получаем информацию о товаре из базы данных
    $query = "SELECT * FROM products WHERE id=$product_id";
    $result = mysqli_query($connect, $query);
    $product = mysqli_fetch_assoc($result);

    // Добавляем товар в корзину
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Проверяем, есть ли товар уже в корзине
    $item_exists = false;
    foreach ($_SESSION['cart'] as &$cart_item) {
        if ($cart_item['id'] == $product_id) {
            $cart_item['quantity'] += 1;
            $_SESSION['flash'] = "Товар \"{$product['name']}\" добавлен в корзину ({$cart_item['quantity']} шт.)";
            $item_exists = true;
            break;
        }
    }

    // Если товара еще нет в корзине, добавляем его
    if (!$item_exists) {
        $cart_item = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1
        ];
        $_SESSION['cart'][] = $cart_item;
        $_SESSION['flash'] = "Товар \"{$product['name']}\" добавлен в корзину";
    }

    header("Location: cart.php");
    exit();
}
?>

<!-- Отображаем все товары -->
<form method="get" action="register.php">
<input type="submit" value="Регистрация">
</form>
<form method="get" action="login.php">
<input type="submit" value="Aвторизация">
</form>
<?php foreach ($products as $product): ?>
    <h3><?= $product['name'] ?></h3>
    <p><?= $product['description'] ?></p>
    <p><?= $product['price'] ?> грн.</p>
    <form method="post">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <button type="submit" name="add_to_cart">Добавить в корзину</button>
    </form>
<?php endforeach; ?>
