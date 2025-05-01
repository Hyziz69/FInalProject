<?php

require_once 'WishlistItem.php';
require_once 'Cart.php';
require_once __DIR__ . '/../tools/functions.php';

class Wishlist {
    private $conn;
    private $userId;

    public function __construct(){
        global $conn;

        if(!isLoggedIn()){
            throw new Exception("User must be logged in to use wishlist.");
        }

        $this->conn = $conn;
        $this->userId = $_SESSION['user']['id'];
    }

    private function getOrCreateWishlistId() {
        $stmt = $this->conn->prepare("SELECT id FROM wishlist WHERE users_id = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }

        $stmt = $this->conn->prepare("INSERT INTO wishlist (users_id) VALUES (1)");
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function addItem(WishlistItem $item) {
        $wishlistId = $this->getOrCreateWishlistId();

        $stmt = $this->conn->prepare("SELECT id FROM wishlist_items WHERE wishlist_id = ? AND clothes_id = ?");
        $stmt->bind_param("ii", $wishlistId, $item->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result->fetch_assoc()) {
            $stmt = $this->conn->prepare("INSERT INTO wishlist_items (wishlist_id, clothes_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $wishlistId, $item->id);
            $stmt->execute();
        }
    }

    public function removeItem($clothesId) {
        $wishlistId = $this->getOrCreateWishlistId();

        $stmt = $this->conn->prepare("DELETE FROM wishlist_items WHERE wishlist_id = ? AND clothes_id = ?");
        $stmt->bind_param("ii", $wishlistId, $clothesId);
        $stmt->execute();
    }

    public function clearWishlist() {
        $wishlistId = $this->getOrCreateWishlistId();

        $stmt = $this->conn->prepare("DELETE FROM wishlist_items WHERE wishlist_id = ?");
        $stmt->bind_param("i", $wishlistId);
        $stmt->execute();
    }

    public function getItems() {
        $wishlistId = $this->getOrCreateWishlistId();

        $sql = "
            SELECT c.id, c.name, c.price 
            FROM wishlist_items wi
            JOIN clothes c ON wi.clothes_id = c.id
            WHERE wi.wishlist_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $wishlistId);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = new WishlistItem($row['id'], $row['name'], $row['price']);
        }

        return $items;
    }

    public function getLength() {
        return count($this->getItems());
    }

    public function moveItemToCart($clothesId, $item) {
        $this->removeItem($clothesId);

        $cart = new Cart(); // You’ll want to refactor Cart just like this class
        $cart->addItem($item);
    }

    public function moveAllToCart() {
    $items = $this->getItems();
    $cart = new Cart(); // assuming it uses DB and knows the user ID

    foreach ($items as $item) {
        // Convert WishlistItem to CartItem (default quantity = 1)
        $cartItem = new CartItem($item->id, $item->name, $item->price, 1); 
        $cart->addItem($cartItem);
    }

    $this->clearWishlist();
}
}