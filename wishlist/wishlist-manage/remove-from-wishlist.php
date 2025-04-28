<?php

require_once '../../classes/Wishlist.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();

    $wishlist = new Wishlist();
    $wishlist->removeItem($_POST['product_id']);
}

header('Location: ../wishlist.php');
exit;