<?php

require_once '../../classes/Wishlist.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();

    $wishlist = new Wishlist();
    $wishlist->clearWishlist();
}

header('Location: ../wishlist.php');
exit;