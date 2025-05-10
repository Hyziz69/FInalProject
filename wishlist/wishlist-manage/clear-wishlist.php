<?php

session_start();

require_once '../../classes/Database.php';
require_once '../../classes/Wishlist.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = Database::getConnection();

    $wishlist = new Wishlist($conn);
    $wishlist->clearWishlist();
}

header('Location: ../wishlist.php');
exit;
