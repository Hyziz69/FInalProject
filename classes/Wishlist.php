<?php

require_once 'WishlistItem.php';
require_once 'Cart.php'; 

class Wishlist {
    private $items = [];

    public function __construct(){
        if(session_status() == PHP_SESSION_NONE){
            session_start();
        }

        if (!isset($_SESSION['wishlist'])){
            $_SESSION['wishlist'] = [];
        }

        $this->items = $_SESSION['wishlist'];
    }

    public function addItem(WishlistItem $item){
        $id = $item->id;

        if (!isset($this->items[$id])) {
            $this->items[$id] = $item;
        }

        $this->updateSession();
    }

    public function removeItem($id){
        if (isset($this->items[$id])) {
            unset($this->items[$id]);
        }

        $this->updateSession();
    }

    public function clearWishlist(){
        $this->items = [];
        $this->updateSession();
    }

    public function getItems(){
        return $this->items;
    }

    public function getLength(){
        return count($this->items);
    }

    private function updateSession(){
        $_SESSION['wishlist'] = $this->items;
    }

    public function moveItemToCart($id, $item){
        if(isset($this->items[$id])) {
            $cart = new Cart();
            $cart->addItem($item);
            $this->removeItem($id);
        }
    }

    public function moveAllToCart(){
        $cart = new Cart();
        foreach ($this->items as $item) {
            $cart->addItem($item);
        }
        $this->clearWishlist();
    }
}
