<?php
require_once '../../classes/Cart.php';
require_once '../../classes/Database.php';

$conn = Database::getConnection();
$cart = new Cart($conn);

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];

$item = new CartItem($id, $name, $price);
$cart->addItem($item);

header('Location: ../../index.php');

exit;
