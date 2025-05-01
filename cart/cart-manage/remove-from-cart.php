<?php
require_once '../../classes/Cart.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $clothesId = (int) $_POST['id'];

    try {
        $cart = new Cart();
        $cart->removeItem($clothesId);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
}

header('Location: ../cart.php');
exit;
