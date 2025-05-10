<?php
session_start();

require_once '../../classes/Database.php';
require_once '../../classes/Cart.php';
require_once '../../tools/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    try {
        $clothesId = (int) $_POST['id'];

        $cart = new Cart();

        $cart->removeItem($clothesId);

        alert('success', 'Item removed from cart.');
    } catch (Exception $e) {
        alert('danger', 'Failed to remove item: ' . $e->getMessage());
    }
} else {
    alert('warning', 'Invalid request.');
}

header('Location: ../cart.php');
exit;
