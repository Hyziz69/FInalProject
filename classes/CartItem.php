<?php

class CartItem {
    public $id;
    public $name;
    public $price;
    public $quantity;

    public function __construct($id, $name, $price, $quantity = 1) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }
    
    public function getTotalPrice() {
        return $this->price * $this->quantity;
    }
}