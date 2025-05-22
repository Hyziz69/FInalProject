<?php
session_start();

require_once '../../classes/Database.php';
require_once '../../classes/Cart.php';
require_once '../../classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    try {
        $clothesId = (int) $_POST['id'];

        $cart = new Cart();

        $cart->removeItem($clothesId);

        User::alert('success', 'Item removed from cart.');
    } catch (Exception $e) {
        User::alert('danger', 'Failed to remove item: ' . $e->getMessage());
    }
} else {
    User::alert('warning', 'Invalid request.');
}

header('Location: ../cart.php');
exit;
