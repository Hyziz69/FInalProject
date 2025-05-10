<?php
require_once '../../classes/Cart.php';
require_once '../../classes/Database.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getConnection(); 
    $cart = new Cart($conn);
    $items = $cart->clearCart();
}

header('Location: ../cart.php');
exit;
