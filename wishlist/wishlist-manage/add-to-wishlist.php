<?php

require_once '../../classes/Wishlist.php';
require_once '../../classes/WishlistItem.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    session_start();

    $wishlist = new Wishlist();
    $item = new WishlistItem($_POST['product_id'], $_POST['product_name'], $_POST['product_price']);
    $wishlist->addItem($item);
}

header('Location: ../../index.php');
exit;