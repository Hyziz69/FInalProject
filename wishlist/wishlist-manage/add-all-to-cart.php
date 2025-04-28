<?php

require_once '../../classes/Wishlist.php';
require_once '../../classes/CartItem.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();

    $wishlist = new Wishlist();
    $items = $wishlist->getItems();

    $cart = new Cart();
    foreach($items as $item){
        $cartItem = new CartItem($item->id, $item->name, $item->price);
        $cart->addItem($cartItem);
    }

    $wishlist->clearWishlist();
}

header('Location: ../wishlist.php');
exit;