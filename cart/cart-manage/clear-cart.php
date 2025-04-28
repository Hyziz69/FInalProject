<?php
require_once '../../classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart = new Cart();
    $items = $cart->clearCart();
}

header('Location: ../cart.php');
exit;
