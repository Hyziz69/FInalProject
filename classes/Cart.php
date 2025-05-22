<?php

require_once 'Database.php';
require_once 'CartItem.php';
require_once 'User.php';

class Cart {
    private $conn;
    private $userId;

    public function __construct() {
        $conn = Database::getConnection();
        $user = new User($conn);
        $this->conn = Database::getConnection(); 
        $this->userId = $user->currentUser()['id'];
    }

    public function getOrCreateCartId() {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE id = ?");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("User does not exist in the database.");
        }

        $stmt = $this->conn->prepare("SELECT id FROM cart WHERE users_id = ?");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return $row['id'];
        }

        $stmt = $this->conn->prepare("INSERT INTO cart (users_id) VALUES (?)");
        $stmt->bind_param("i", $this->userId);
        $stmt->execute();
        
        return $this->conn->insert_id;
    }

    public function addItem(CartItem $item) {
        $cartId = $this->getOrCreateCartId();

        $stmt = $this->conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND clothes_id = ?");
        $stmt->bind_param("ii", $cartId, $item->id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $newQuantity = $row['quantity'] + $item->quantity;
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $newQuantity, $row['id']);
            $stmt->execute();
        } else {
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, clothes_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $cartId, $item->id, $item->quantity);
            $stmt->execute();
        }
    }

    public function getItems() {
    $cartId = $this->getOrCreateCartId();

    $sql = "
        SELECT ci.id AS cart_item_id, c.name, c.price, ci.quantity 
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
        $items[] = new CartItem($row['cart_item_id'], $row['name'], $row['price'], $row['quantity']);
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

        $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = ? AND id = ?");
        $stmt->bind_param("ii", $cartId, $clothesId);
        $stmt->execute();

    }


}
