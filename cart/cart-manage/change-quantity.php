<?php

require_once '../../classes/Cart.php';
require_once '../../classes/Database.php';

$conn = Database::getConnection(); 
$cart = new Cart($conn);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user']['id'] ?? null;
$item_id = $_POST['item_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if (!$user_id || !$item_id || !$quantity) {
    header('Location: ../cart.php?error=invalid_input');
    exit;
}

if ($quantity < 1) {
    $quantity = 1;
}

$stmt = $conn->prepare("
    UPDATE cart_items 
    JOIN cart ON cart.id = cart_items.cart_id 
    SET cart_items.quantity = ? 
    WHERE cart.users_id = ? AND cart_items.id = ?
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("iii", $quantity, $user_id, $item_id);

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$stmt->close();

header('Location: ../cart.php');
exit;
