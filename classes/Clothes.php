<?php

class Clothes {
    public $id;
    public $name;
    public $description;
    public $price;
    public $gender;
    public $type;
    public $image_url;

    public function __construct($id, $name, $description, $price, $gender, $type, $image_url) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->gender = $gender;
        $this->type = $type;
        $this->image_url = $image_url;
    }

    public function getUrl() {
        return "clothing.php?id=" . $this->id;
    }
}
