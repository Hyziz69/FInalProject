<?php

require_once 'CartItem.php';
require_once __DIR__ . '/../tools/functions.php';

class Cart {
    private $conn;
    private $userId;

    public function __construct() {
        global $conn;

        if (!isLoggedIn()) {
            throw new Exception("User must be logged in to use cart.");
        }

        $this->conn = $conn;
        $this->userId = $_SESSION['user']['id'];
    }

    private function getOrCreateCartId() {
        // Check if user exists in the users table
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        // If the user doesn't exist, stop here and throw an error
        if ($result->num_rows === 0) {
            throw new Exception("User does not exist in the database.");
        }

        // Check if the user already has a cart
        $stmt = $this->conn->prepare("SELECT id FROM cart WHERE users_id = 1");
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Return existing cart ID
            return $row['id'];
        }

        // If no cart exists for the user, create a new one
        $stmt = $this->conn->prepare("INSERT INTO cart (users_id) VALUES (1)");
        $stmt->execute();
        
        // Return the newly created cart ID
        return $this->conn->insert_id;
    }

    public function addItem(CartItem $item) {
        $cartId = $this->getOrCreateCartId();

        // Check if item already in cart
        $stmt = $this->conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND clothes_id = ?");
        $stmt->bind_param("ii", $cartId, $item->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Update quantity if item already in cart
            $newQuantity = $row['quantity'] + $item->quantity;
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $newQuantity, $row['id']);
            $stmt->execute();
        } else {
            // Insert new item into cart
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, clothes_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $cartId, $item->id, $item->quantity);
            $stmt->execute();
        }
    }

    public function getItems() {
        $cartId = $this->getOrCreateCartId();

        $sql = "
            SELECT c.id, c.name, c.price, ci.quantity 
            FROM cart_items ci
            JOIN clothes c ON ci.clothes_id = c.id
            WHERE ci.cart_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $cartId);
        $stmt->execute();
        $result = $stmt->get_result();

        $items = [];
        while ($row = $result->fetch_assoc()) {
            $items[] = new CartItem($row['id'], $row['name'], $row['price'], $row['quantity']);
        }

        return $items;
    }

    public function getTotal() {
        $items = $this->getItems();
        $total = 0;

        foreach ($items as $item) {
            $total += $item->getTotalPrice();
        }

        return $total;
    }

    public function getLength() {
        return count($this->getItems());
    }

    public function clearCart() {
        $cartId = $this->getOrCreateCartId();

        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        $stmt->bind_param("i", $cartId);
        $stmt->execute();
    }

    public function removeItem($clothesId) {
        $cartId = $this->getOrCreateCartId();

        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND clothes_id = ?");
        $stmt->bind_param("ii", $cartId, $clothesId);
        $stmt->execute();
    }


}
