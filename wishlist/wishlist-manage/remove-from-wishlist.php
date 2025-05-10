<?php

require_once '../../classes/Wishlist.php';
require_once '../../classes/Database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    session_start();
    $conn = Database::getConnection();

    $wishlist = new Wishlist($conn);
    $wishlist->removeItem($_POST['product_id']);
}

header('Location: ../wishlist.php');
exit;