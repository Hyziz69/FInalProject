<?php

session_start();

require_once '../../classes/Database.php';
require_once '../../classes/Wishlist.php';
require_once '../../classes/WishlistItem.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getConnection();

    $wishlist = new Wishlist($conn);
    $item = new WishlistItem($_POST['product_id'], $_POST['product_name'], $_POST['product_price']);
    $wishlist->addItem($item);
}

header('Location: ../../index.php');
exit;
