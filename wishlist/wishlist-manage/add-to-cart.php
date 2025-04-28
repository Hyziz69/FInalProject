<?php

require_once '../../classes/Wishlist.php';
require_once '../../classes/CartItem.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();

    $itemId = $_POST['product_id'];
    $itemName = $_POST['product_name'];
    $itemPrice = $_POST['product_price'];
    $item = new CartItem($itemId, $itemName, $itemPrice);
    
    $wishlist = new Wishlist();
    $wishlist->moveItemToCart($itemId, $item);
}

header('Location: ../wishlist.php');
exit;