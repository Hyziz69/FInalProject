<?php
require_once '../../classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $cart = new Cart();
    $items = $cart->getItems();

    if (isset($items[$id])) {
        unset($items[$id]);
        $_SESSION['cart'] = $items; 
    }
}

header('Location: ../cart.php');
exit;
