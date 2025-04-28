<?php

require_once 'CartItem.php';

class Cart {
    private $items = [];

    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }
        
        if (!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }

        $this->items = $_SESSION['cart'];
    }

    public function addItem(CartItem $item){
        $id = $item->id;

        if (isset($this->items[$id])){
            $this->items[$id]->quantity += $item->quantity;
        } else {
            $this->items[$id] = $item;
        }

        $this->updateSession();
    }

    public function getItems(){
        return $this->items;
    }

    public function getTotal(){
        $total = 0;
        foreach ($this->items as $item){
            $total += $item->getTotalPrice();
        }
        return $total;
    }

    private function updateSession(){
        $_SESSION['cart'] = $this->items;
    }

    public function getLength(){
        return count($this->items);
    }

    public function clearCart(){
        $this->items = [];
        $this->updateSession();
    }
}