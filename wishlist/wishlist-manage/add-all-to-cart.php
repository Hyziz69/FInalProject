<?php

session_start();

require_once '../../classes/Database.php';
require_once '../../classes/Wishlist.php';
require_once '../../classes/CartItem.php';
require_once '../../classes/Cart.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getConnection();

    $wishlist = new Wishlist($conn);
    $items = $wishlist->getItems();

    $cart = new Cart($conn);
    foreach ($items as $item) {
        $cartItem = new CartItem($item->id, $item->name, $item->price);
        $cart->addItem($cartItem);
    }

    $wishlist->clearWishlist();
}

header('Location: ../wishlist.php');
exit;
